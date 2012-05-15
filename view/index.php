﻿<?php

include("../includes/pg_details.php");
$pg_title = "Protein Viewer";

//get the code from post/get
if (isset($_GET['id']))
	$id = trim($_GET['id']);
//post data will override get data
if (isset($_POST['id']))
	$id = trim($_POST['id']);

//check for null
if ($id == '0' || $id == NULL)
	unset($id);

//check for valid data
if (!check_viewer_code($id,$conn))
	unset($id);

//include header block to page
include("../includes/header_a.php");

?>

<script src="../graphics/js-unzip.js"></script>
<script src="../graphics/js-inflate.js"></script>
<script src="../graphics/jquery.js"></script>
<script src="../graphics/surfacedata.js"></script>
<script src="../graphics/chainsurface.js"></script>
<script src="../graphics/BinaryReader.js"></script>
<script src="../zip/zip.js"></script>
<script src="../graphics/ply.js"></script>
<script src="../graphics/decal.js"></script>
<script src="../graphics/events.js"></script>
<script src="../graphics/DataView.js"></script>

<script src="../graphics/GL.js"></script>
<script src="../graphics/GLSL_Shader.js"></script>
<script src="../graphics/Debug.js"></script>
<script src="../graphics/Helper.js"></script>
<script src="../graphics/glMatrix.js"></script>

<script>

	var HBondsStickersVisible = false;
	function ToggleHBondsStickersVisible()
	{
		if(HBondsStickersVisible)
		{
			$("#ToggleHBondsStickers").removeClass("visible");
			$("#ToggleHBondsStickers").addClass("invisible");
			HBondsStickersVisible = false;
		}
		else
		{
			$("#ToggleHBondsStickers").removeClass("invisible");
			$("#ToggleHBondsStickers").addClass("visible");
			HBondsStickersVisible = true;
		}
	}

	var DetectedPocketsStickersVisible = false;
	function ToggleDetectedPocketsStickersVisible()
	{
		if(DetectedPocketsStickersVisible)
		{
			$("#ToggleDetectedPocketsStickers").removeClass("visible");
			$("#ToggleDetectedPocketsStickers").addClass("invisible");
			DetectedPocketsStickersVisible = false;
		}
		else
		{
			$("#ToggleDetectedPocketsStickers").removeClass("invisible");
			$("#ToggleDetectedPocketsStickers").addClass("visible");
			DetectedPocketsStickersVisible = true;
		}
	}

	var InterfacesStickersVisible = false;
	function ToggleInterfacesStickersVisible()
	{
		if(InterfacesStickersVisible)
		{
			$("#ToggleInterfacesStickers").removeClass("visible");
			$("#ToggleInterfacesStickers").addClass("invisible");
			InterfacesStickersVisible = false;
		}
		else
		{
			$("#ToggleInterfacesStickers").removeClass("invisible");
			$("#ToggleInterfacesStickers").addClass("visible");
			InterfacesStickersVisible = true;
		}
	}

	var PeakBowlStickersVisible = true;
	function TogglePeakBowlStickersVisible()
	{
		if(PeakBowlStickersVisible)
		{
			$("#TogglePeakBowlStickers").removeClass("visible");
			$("#TogglePeakBowlStickers").addClass("invisible");
			PeakBowlStickersVisible = false;
		}
		else
		{
			$("#TogglePeakBowlStickers").removeClass("invisible");
			$("#TogglePeakBowlStickers").addClass("visible");
			PeakBowlStickersVisible = true;
		}
	}

	String.prototype.startsWith = function(str) 
	{return (this.match("^"+str)==str)}

	String.prototype.endsWith = function(str) 
	{return (this.match(str+"$")==str)}	
	
	/******************************************************/
	/* Attach windows loaded event listener
	/******************************************************/
	window.addEventListener("load", WindowLoaded, false);
	
	/******************************************************/
	/* Global Variables
	/******************************************************/
	var Loading = true;
	var gl = null;
	var prevTime;
	var EnzymeShader = {};
	var DecalShader = {};
	var Time = 0;
	var Surface;
	var Selected;
	
	/******************************************************/
	/* WindowLoaded
	/*
	/* This function is attached to the Window Loaded event
	/* and is where we initialize our variables and then 
	/* start the game loop
	/******************************************************/
	function WindowLoaded()
	{
		var canvas = document.getElementById("View");
		gl = InitializeWebGL(canvas);
		if(!gl)
			return;
		
		// Attach event listeners
		window.addEventListener("resize", OnResize, false);
		OnResize();
		
		var urlVars = getUrlVars();
		var id = <?php echo '"' . $id . '"'; ?>;
		var path = "../output";
		
		Surface = new surfacedata(id, path);
		Surface.load(SurfaceLoaded);
		
		// Load the shaders
		gl.loadShaders(["Enzyme", "Decal"], "../graphics/"); 
		EnzymeShader = gl.getShader("Enzyme");
		DecalShader = gl.getShader("Decal");

		// Set initial time
		var curDate = new Date().getTime();
		prevTime = curDate;
		
		// Start the gameloop
		Loop();
		checkGLError();
	}
	
	
	function OnResize()
	{
		// Make sure the canvas height is correct
		var height =  window.innerHeight;
		$("#v_content").height(height-185);
		$("#v_cover").height(height-185);
	}
	
	function SurfaceLoaded()
	{
		var list = document.getElementById("SurfaceData");
		
		for(var i = 0; i < Surface.chainsurfaces.length; i++)
		{
			var cs = Surface.chainsurfaces[i];
			var new_cs = document.createElement('li');
			new_cs.innerHTML = "<h4> ChainSurface </h4>";
			var new_ul = document.createElement('ul');
			if(cs.orig_surfacefile != null)
			{
				var new_file = document.createElement('li');
				new_file.innerText = "Original: " + cs.orig_surfacefilename;
				new_file.setAttribute("onclick", "Selected = Surface.chainsurfaces["+i+"].orig_surfacefile;");
				new_file.setAttribute("style", "cursor:pointer;color:blue;");
				new_ul.appendChild(new_file);
			}
			
			if(cs.abstract_surfacefile != null)
			{
				var new_file = document.createElement('li');
				new_file.innerText = "Abstract: " + cs.abstract_surfacefilename;
				new_file.setAttribute("onclick", "Selected = Surface.chainsurfaces["+i+"].abstract_surfacefile;");
				new_file.setAttribute("style", "cursor:pointer;color:blue;");
				new_ul.appendChild(new_file);
			}
	
			new_cs.appendChild(new_ul);
			list.appendChild(new_cs);
		}
	}
	
	/******************************************************/
	/* Loop
	/*
	/* This function is called every Frame and then updates
	/* all the game objects and then draws them. It then
	/* sets a timer so the function will call itself in 
	/* another 60th of a second
	/******************************************************/
	function Loop()
	{
		Timer = setTimeout("Loop()", 1/30 * 1000);
		var curTime = new Date().getTime();
		var DeltaMiliSec = curTime - prevTime;
		prevTime = curTime;
		
		Update(DeltaMiliSec);
		Draw();
		checkGLError();
	}

	/******************************************************/
	/* Update
	/*
	/* Update movement
	/******************************************************/
	function Update(DeltaMiliSec) 
	{
	  	Time += DeltaMiliSec;
	}
	
	/******************************************************/
	/* Draw
	/*
	/* Draw the world.
	/******************************************************/
	var Light0_Enabled = true;
	var Up = [0,1,0];
	var CameraPos = [70, 0, 70];
	var LookAt = [0,0,0];
	function Draw()
	{
		gl.clearColor(0.0, 0.0, 0.0, 1.0);
		//gl.clearDepth(1);
		
		gl.enable(gl.DEPTH_TEST);
		gl.depthFunc(gl.LESS);
		
		// MWA - dont know why it isnt resizing correctly
		gl.canvas.width = gl.canvas.offsetWidth;
		gl.canvas.height = gl.canvas.offsetHeight;
		gl.viewportWidth  = gl.canvas.offsetWidth;
		gl.viewportHeight = gl.canvas.offsetHeight;
		
		gl.viewport(0, 0, gl.viewportWidth, gl.viewportHeight);
		gl.clear(gl.COLOR_BUFFER_BIT | gl.DEPTH_BUFFER_BIT);
		
		mat4.perspective(45, gl.viewportWidth / gl.viewportHeight, 2.0, 2000.0, gl.pMatrix);
		
		mat4.lookAt(CameraPos, LookAt, Up, gl.vMatrix);	
		mat4.identity(gl.mvMatrix);
		
		if(Selected != null)
			Selected.draw(EnzymeShader.Program, DecalShader.Program);
	}	
</script>


<?php

if (!isset($id))
{
	echo "<div class='center'><div class='login_form'><form action=\"#\" method=\"post\">";
		echo "<h3>Please enter a valid protein viewer code to get started</h3>";
		echo "<input type=\"text\" name=\"id\"><p style=\"color: white;\">Viewer Code</p>";
		echo "<input type=\"submit\" value=\"View\" id=\"form_submit\" 
				style=\"width: 100px; background-color:#CCC; color: black; border:#666 3px solid; padding: 0 0 0 0;\" />";
	echo "</form></div></div>";
	
	echo "<div id=\"v_cover\"></div>";	
	

}
?>

<div id="v_wrapper">
	<div id="v_content">
			<div id="v_mainview" onMouseOut="MouseOut(event);" onMouseOver="MouseOver(event);">
				<canvas id="View" onmousemove="MouseMoved(event);" onmousewheel="MouseWheel(event);"
					onmousedown="mouseDown = true;" onmouseup="mouseDown = false;">
				</canvas>
			</div>
			<div id="Selector" style="display:inline-block; vertical-align: top;">
				<div class="toggle invisible" id="ToggleHBondsStickers" onClick="ToggleHBondsStickersVisible();"
				title="Hydrogen bond stickers are placed on the surface in areas that are close to one or more atoms that could form an external hydrogen bond.">
				H-Bonds</div>
				<div class="toggle invisible" id="ToggleDetectedPocketsStickers" onClick="ToggleDetectedPocketsStickersVisible();"
				title="Detected Pockets indicate regions of the surface that resemble binding pockets, according to a variant of the Ligsite pocket detector.">
				Detected Pockets</div>
				<div class="toggle invisible" id="ToggleInterfacesStickers" onClick="ToggleInterfacesStickersVisible();"
				title="Interfaces indicate regions of the surface in close proximity to another chain.">
				Interferences</div>
				<div class="toggle visible" id="TogglePeakBowlStickers" onClick="TogglePeakBowlStickersVisible();"
				 title="peak/bowl stickers display as an 'X' or 'O', respectively, points where significant peaks or bumps in the original solvent excluded surface were removed.">
				 Peaks/Bowls</div>
				<h3>Surface Data</h3>
				<ul id="SurfaceData">
				</ul>
			</div>
	</div>
</div>

<?php
//include footer block into webpage
include("../includes/footer_a.php");
?>
