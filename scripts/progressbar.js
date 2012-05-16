function updateProgressBar(percent)
{
	Debug.Trace("Update Progress Bar: " + percent);
	if(percent >= 100)
	{
		$("#progressbar").hide();
		Debug.Trace("Hide Progress Bar");
	}
	else if(percent >= 0)
	{
		$("#percent").css("width", percent + "%");
	}
}