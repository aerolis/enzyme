<?php

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

<script src="../scripts/toggle.js"></script>
<script src="../scripts/progressbar.js"></script>

<script>
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
		window.addEventListener('DOMMouseScroll', MouseWheel, false);
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
		var height 	= window.innerHeight;
		var width	= window.innerWidth;
		$("#v_content").height(height-185);
		$("#v_cover").height(height-185);
		$("#v_mainview").width(Math.max(0,width-650));
		$("#View").width(Math.max(0,width-650));
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
		
		for(var i = 0; i < Surface.chainsurfaces.length; i++)
		 	Surface.chainsurfaces[i].draw(AbstractToggle, EnzymeShader.Program, DecalShader.Program);
	}	
</script>


<?php

if (!isset($id))
{
	echo "<div class='center'><div class='login_form'><form action=\"#\" method=\"post\" id=\"view_form\">";
		echo "<h3>Please enter a valid protein viewer code to get started</h3>";
		echo "<input type=\"text\" name=\"id\"><p style=\"color: white;\">Viewer Code</p>";
		echo "<img class=\"submit\" src=\"../images/view.png\" onclick=\"submitForm('view_form',true,'');\"/>";
	echo "</form></div></div>";
	
	echo "<div id=\"v_cover\"></div>";	
	

}
?>

<!--<div class="center" style='z-index: 4;'>
	<div id="progressbar">
		<div id="percent">
        &nbsp;
		</div>
	</div>
</div>-->

<div id="v_wrapper">
		<div id="v_content">
			<div id="chain_selector">
            
				<div class="view_toggle">
                	<img src="../images/icons/on_120_30.png" id="AbstractToggle" onClick="ToggleAbstractView();"/>
					Abstracted View
				</div>
			
            	<h3>Chain Surfaces</h3>
				<div id="SurfaceData">
				</div>
			</div>
            
			<div id="v_mainview" onMouseOut="MouseOut(event);" onMouseOver="MouseOver(event);">
				<canvas id="View" onmousemove="MouseMoved(event);" onmousewheel="MouseWheel(event);"
					onmousedown="mouseDown = true;" onmouseup="mouseDown = false;">
				</canvas>
			</div>
            
			<div id="sticker_selector">
            
				<div class="view_toggle"  
					title="Hydrogen bond stickers are placed on the surface in areas that are close to one or more atoms that could form an external hydrogen bond.">
                	<img src="../images/icons/off_120_30.png" id="ToggleHBondsStickers" onClick="ToggleHBondsStickersVisible();"/>
					H-Bonds</div>
                    
				<div class="view_toggle" 
					title="Detected Pockets indicate regions of the surface that resemble binding pockets, according to a variant of the Ligsite pocket detector.">
                    <img src="../images/icons/off_120_30.png" id="ToggleDetectedPocketsStickers" onClick="ToggleDetectedPocketsStickersVisible();"/>
					Detected Pockets</div>
                    
				<div class="view_toggle" 
					title="Interfaces indicate regions of the surface in close proximity to another chain.">
                    <img src="../images/icons/off_120_30.png" id="ToggleInterfacesStickers" onClick="ToggleInterfacesStickersVisible();"/>
					Interferences</div>
                    
				<div class="view_toggle" 
					 title="peak/bowl stickers display as an 'X' or 'O', respectively, points where significant peaks or bumps in the original solvent excluded 				
                     surface were removed.">
                    <img src="../images/icons/on_120_30.png" id="TogglePeakBowlStickers" onClick="TogglePeakBowlStickersVisible();"/>
				 	Peaks/Bowls</div>
				
                <div class='viewer_form'>
                	<h2>Current Protein</h2>
                    <h3>Name: </h3><p><?php echo printJobName($id,$conn);?></p>
                    <h3>Code: </h3><p><?php echo $id;?></p>
                </div>
                
                <div class='viewer_form'>
                	<form action="#" method="post" id="view_form">
                    <h3>&nbsp;</h3>
					<input type="text" name="id"><p>Viewer Code</p>
					<img class="submit" src="../images/view.png" onclick="submitForm('view_form',true,'');"/>
					</form>
                </div>
                
			</div>
	</div>
</div>

<?php
//include footer block into webpage
include("../includes/footer_a.php");
?>
