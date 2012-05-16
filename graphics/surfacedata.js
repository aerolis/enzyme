function surfacedata(id, path, i_Callback)
{
	this.path = path + "/" + id + "/" + id + "_uncompressed/";
	this.id = id;
	this.filename = "decal-" + id + ".xml";
	
	//this.filename = id + "_uncompressed.zip";
	//this.zip = new Zip(this.path + this.filename);
	
	this.load = function(success, failure)
	{
		Debug.Trace("Loading " + this.filename);
		var sd = this;
		var xhr = new XMLHttpRequest();
		xhr.onreadystatechange = function()
		{
			Debug.Trace("XMLHttpRequest Ready State Changed");
			if (xhr.readyState == xhr.DONE) 
			{
				Debug.Trace("XMLHttpRequest Ready State Done");

				if ((xhr.status == 200 || xhr.status == 0) && xhr.responseXML) // MWA - for some reason local tests return 0 on ready 
				{
					Debug.Trace("XMLHttpRequest Status OK");
					var xml = xhr.responseXML;
					
		/*sd.zip.load(
			function()
			{
				var file = DataViewToString(sd.zip.getFile("decal-" + sd.id + ".xml").Data);
				var xml = StringtoXML(file);
*/
					
					for(var i = 0; i < xml.childNodes.length; i++)
					{
						var node = xml.childNodes[i];
						if(node instanceof Element && node.nodeName == "surfacedata")
						{
							sd.parseSurfaceData(node);
						}
						else if(node instanceof Text)
						{
							// Ignore Text
						}
						else
						{
							throw 2;
						}
					}
					
					if(success != null)
						success();
			/*},
			failure
			);*/

				} 
				else 
				{
					throw 1;
				}
			
			}
			
		}
		
		// Open the request for the provided url
		xhr.open("GET", this.path + this.filename, true);  
		xhr.send();
	}
	
	this.chainsurfaces = [];
	this.parseSurfaceData = function(xml)
	{
		Debug.Trace("Parsing Surface Data");
		this.numchains = 0;
		for(var i = 0; i < xml.attributes.length; i++)
		{
			var attribute = xml.attributes[i];
			if(attribute.name == "numchains")
			{
				this.numchains = parseInt(attribute.value, 10);
				Debug.Trace("SurfaceData has "+this.numchains+" Chain Surfaces");
			}
		}

	
		for(var i = 0; i < xml.childNodes.length; i++)
		{
			var node = xml.childNodes[i];
			if(node instanceof Element)
			{
				if(node.nodeName == "chainsurface")
				{
					var cs = new chainsurface(node);
					
					// load the mesh files
					if(cs.abstract_surfacefilename != "")
					{
						cs.abstract_surfacefile = new ply.file(
							this.path,//this.zip,
							cs.abstract_surfacefilename, 
							cs.abstract_ambient_occlusion, 
							cs.decallists
							);
						cs.abstract_surfacefile.load();
					}
					if(cs.orig_surfacefilename != "")
					{
						cs.orig_surfacefile = new ply.file(
							this.path,//this.zip,
							cs.orig_surfacefilename, 
							cs.orig_ambient_occlusion
							);
						cs.orig_surfacefile.load();
					}
					
					this.chainsurfaces.push(cs);
				}
				else
				{
					throw 4;
				}
			}
			else if(node instanceof Text)
			{
				// Ignore Text
			}
			else
			{
				throw 3;
			}
		}
	}
}