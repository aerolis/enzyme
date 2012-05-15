function checkEmailConsistency()
{
	if (document.getElementsByName("email1").item(0).value != document.getElementsByName("email2").item(0).value)
	{
		$("#email_spacer").html("Email addresses do not match");
		return false;
	}
	else
	{
		$("#email_spacer").html("&nbsp;");
		return true;
	}
}
function checkPassConsistency()
{
	if (document.getElementsByName("pass1").item(0).value != document.getElementsByName("pass2").item(0).value)
	{
		$("#pass_spacer").html("Passwords do not match");
		return false;
	}
	else
	{
		$("#pass_spacer").html("&nbsp;");
		return true;
	}
}
function checkRegisterReady()
{
	var inputs = new Array();
	inputs.push("fname");
	inputs.push("lname");
	inputs.push("email1");
	inputs.push("email2");
	inputs.push("pass1");
	inputs.push("pass2");
	
	var i = 0;
	var check = true;
	for (i=0;i<inputs.length;i++)
	{
		if (document.getElementsByName(inputs[i]).item(0).value == "")
			check = false;
	}
	//now check pass and email consistency
	if (!checkEmailConsistency() || !checkPassConsistency())
		check = false;	
	
	if (!check)
	{
		$("#form_check").html("Please complete all required fields to continue");
		$("#form_submit").prop("disabled","disabled");
	}
	else
	{
		$("#form_check").html("");
		$("#form_submit").removeProp("disabled");
	}
}

var W3CDOM = (document.createElement && document.getElementsByTagName);

function initFileUploads() {
	if (!W3CDOM) return;
	var fakeFileUpload = document.createElement('div');
	fakeFileUpload.className = 'fakefile';
	fakeFileUpload.appendChild(document.createElement('input'));
	var image = document.createElement('img');
	image.src='../images/select.png';
	image.style.paddingTop='5px';
	fakeFileUpload.appendChild(image);
	var x = document.getElementsByTagName('input');
	for (var i=0;i<x.length;i++) {
		if (x[i].type != 'file') continue;
		if (x[i].parentNode.className != 'fileinputs') continue;
		x[i].className = 'file hidden';
		var clone = fakeFileUpload.cloneNode(true);
		x[i].parentNode.appendChild(clone);
		x[i].relatedElement = clone.getElementsByTagName('input')[0];
		x[i].onchange = x[i].onmouseout = function () {
			this.relatedElement.value = this.value;
		}
	}
}