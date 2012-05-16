	var AbstractToggle = true;
	function ToggleAbstractView()
	{
		Debug.Trace("Toggle Abstract View: "+!AbstractToggle);
		AbstractToggle = toggleonoff("AbstractToggle");
	}
	
	function plySurfaceName(filename)
	{
		var index = filename.indexOf('.');
		if(index > 0)
		{
			var name = filename.substr(0, index);
			name = name.substr(name.lastIndexOf('_')+1,name.length-1);
			return name;
		}
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
				var new_cs = document.createElement('div');
				var filename = plySurfaceName(cs.orig_surfacefilename);
				new_cs.innerHTML = "<img src='../images/icons/on_120_30.png' id='cs_"+i+"' onClick='toggleChainSurfaceDisplay("+i+");'/>" + filename;
				new_cs.setAttribute("class", "view_toggle");

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
		Surface.chainsurfaces[index].enabled = toggleonoff("cs_" + index);
	} 

	var HBondsStickersVisible = false;
	function ToggleHBondsStickersVisible()
	{
		HBondsStickersVisible = toggleonoff("ToggleHBondsStickers");
	}

	var DetectedPocketsStickersVisible = false;
	function ToggleDetectedPocketsStickersVisible()
	{
		DetectedPocketsStickersVisible = toggleonoff("ToggleDetectedPocketsStickers");
	}

	var InterfacesStickersVisible = false;
	function ToggleInterfacesStickersVisible()
	{
		InterfacesStickersVisible = toggleonoff("ToggleInterfacesStickers");
	}

	var PeakBowlStickersVisible = true;
	function TogglePeakBowlStickersVisible()
	{
		PeakBowlStickersVisiblee = toggleonoff("TogglePeakBowlStickers");
	}
