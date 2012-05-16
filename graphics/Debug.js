/******************************************************/
/* Debug.js
/*
/* Helper class that make debugging javascript easier
/******************************************************/
var Debug = function() {};

function addZeroTen(i)
{
	if (i<10)
		i= "0" + i;
		
	return i;
}

function addZeroHundred(i)
{
	if (i<10)
		i= "00" + i;
	else if(i<100)
		i= "0" + i;
		
	return i;
}


/******************************************************/
/* Debug.Trace
/*
/* Helpful little global variable that makes printing 
/* to the console easy.
/******************************************************/
Debug.Trace = function(i_Message)
{
  try
  {
  	var today=new Date();
	var h=addZeroTen(today.getHours());
	var m=addZeroTen(today.getMinutes());
	var s=addZeroTen(today.getSeconds());
	var ms=addZeroHundred(today.getMilliseconds());
    console.log("["+h+":"+m+":"+s+"."+ms+"] "+i_Message);
  }
  catch(e)
  {
    return;
  }
}

/******************************************************/
/* Debug.Trace
/*
/* Helpful little global variable that makes printing 
/* an error to the console easy.
/******************************************************/
Debug.Error = function(i_Message)
{
  try
  {
    console.error(i_Message);
  }
  catch(e)
  {
    return;
  }
}

Debug.error = Debug.Error;
