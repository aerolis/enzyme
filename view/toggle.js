	var AbstractToggle = true;
	function toggleAbstractView()
	{
		Debug.Trace("Toggle Abstract View: "+!AbstractToggle);
		if(AbstractToggle)
		{
			AbstractToggle = true;
			$("#AbstractToggle").removeClass("view_visible");
			$("#AbstractToggle").addClass("view_invisible");

		}
		else
		{
			AbstractToggle = false;
			$("#AbstractToggle").removeClass("view_invisible");
			$("#AbstractToggle").addClass("view_visible");
		}
	}
	
	function plySurfaceName(filename)
	{
		var index = filename.indexOf('.');
		if(index > 0)
			return filename.substr(0, index);
		else
			return filename;
	}
	
	function SurfaceLoaded()
	{
		Debug.Trace("Surface Loaded");
		var list = document.getElementById("SurfaceData");
		
		for(var i = 0; i < Surface.chainsurfaces.length; i++)
		{
			var cs = Surface.chainsurfaces[i];
			if(cs.orig_surfacefile != null)
			{
				var new_cs = document.createElement('li');
				var filename = plySurfaceName(cs.orig_surfacefilename);
				new_cs.innerHTML = "<h4>" + filename + "</h4>";
				new_cs.setAttribute("onclick", "toggleChainSurfaceDisplay("+i+")");
				new_cs.setAttribute("id", "cs_" + i);
				new_cs.setAttribute("class", "chainsurface view_visible");

				/*if(cs.abstract_surfacefile != null)
				{
					var new_file = document.createElement('li');
					new_file.innerText = "Abstract: " + cs.abstract_surfacefilename;
					new_file.setAttribute("onclick", "Selected = Surface.chainsurfaces["+i+"].abstract_surfacefile;");
					new_file.setAttribute("style", "cursor:pointer;color:blue;");
					new_ul.appendChild(new_file);
				}*/
				
				list.appendChild(new_cs);
			}
			
		}
	}
	
	function toggleChainSurfaceDisplay(index)
	{
		if(Surface.chainsurfaces[index].enabled)
		{
			Surface.chainsurfaces[index].enabled = false;
			$("#cs_" + index).removeClass("view_visible");
			$("#cs_" + index).addClass("view_invisible");
		}
		else
		{
			Surface.chainsurfaces[index].enabled = true;
			$("#cs_" + index).removeClass("view_invisible");
			$("#cs_" + index).addClass("view_visible");

		}
	} 

	var HBondsStickersVisible = false;
	function ToggleHBondsStickersVisible()
	{
		if(HBondsStickersVisible)
		{
			$("#ToggleHBondsStickers").removeClass("view_visible");
			$("#ToggleHBondsStickers").addClass("view_invisible");
			HBondsStickersVisible = false;
		}
		else
		{
			$("#ToggleHBondsStickers").removeClass("view_invisible");
			$("#ToggleHBondsStickers").addClass("view_visible");
			HBondsStickersVisible = true;
		}
	}

	var DetectedPocketsStickersVisible = false;
	function ToggleDetectedPocketsStickersVisible()
	{
		if(DetectedPocketsStickersVisible)
		{
			$("#ToggleDetectedPocketsStickers").removeClass("view_visible");
			$("#ToggleDetectedPocketsStickers").addClass("view_invisible");
			DetectedPocketsStickersVisible = false;
		}
		else
		{
			$("#ToggleDetectedPocketsStickers").removeClass("view_invisible");
			$("#ToggleDetectedPocketsStickers").addClass("view_visible");
			DetectedPocketsStickersVisible = true;
		}
	}

	var InterfacesStickersVisible = false;
	function ToggleInterfacesStickersVisible()
	{
		if(InterfacesStickersVisible)
		{
			$("#ToggleInterfacesStickers").removeClass("view_visible");
			$("#ToggleInterfacesStickers").addClass("view_invisible");
			InterfacesStickersVisible = false;
		}
		else
		{
			$("#ToggleInterfacesStickers").removeClass("view_invisible");
			$("#ToggleInterfacesStickers").addClass("view_visible");
			InterfacesStickersVisible = true;
		}
	}

	var PeakBowlStickersVisible = true;
	function TogglePeakBowlStickersVisible()
	{
		if(PeakBowlStickersVisible)
		{
			$("#TogglePeakBowlStickers").removeClass("view_visible");
			$("#TogglePeakBowlStickers").addClass("view_invisible");
			PeakBowlStickersVisible = false;
		}
		else
		{
			$("#TogglePeakBowlStickers").removeClass("view_invisible");
			$("#TogglePeakBowlStickers").addClass("view_visible");
			PeakBowlStickersVisible = true;
		}
	}
