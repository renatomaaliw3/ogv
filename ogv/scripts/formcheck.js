window.onload = initForms;

function initForms() {

	for (var i = 0; i < document.forms.length; i++) {
	
		document.forms[i].onsubmit = function() {
		
			return validForm();
		
		}
	
	}

}

function validForm() {

	var allGood = true;
	var allTags = document.getElementsByTagName("*");
	
	for (var i = 0; i < allTags.length; i++) {
	
		if (!validTag(allTags[i])) {
		
			allGood = false;
		
		}
	
	}
	
	return allGood;
	
	function validTag(thisTag) {
	
		var outClass = "";
		var allClasses = thisTag.className.split(" ");
		
		for (var j=0; j < allClasses.length; j++) {
		
			outClass += validBasedOnClass(allClasses[j]) + " ";
			
		}
	
		thisTag.className = outClass;
		
		if (outClass.indexOf("invalid") > -1) {
		
			thisTag.focus();
			alert("Please supply required information!");
			
			if (thisTag.nodeName == "input" || thisTag.nodeName == "textarea") {
				
				thisTag.select();
				
			
			}
			return false;
		
		}
		return true;
		
		function validBasedOnClass(thisClass) {
		
			var classBack = "";
			
			switch (thisClass) {
			
				case "":
				case "invalid":
					break;
				case "textfield":
				case "shorttext":
				case "multitext":
				
					if (allGood && thisTag.value == "") {
					
						classBack = "invalid ";
					
					}
					classBack += thisClass;
					break;
					
				default:
				
					classBack += thisClass;
					allGood = matchPassword(); //match password
					
							
					
			}
			return classBack;
			
			function matchPassword() {	
					
				if (document.getElementById("password").value == document.getElementById("confirmpassword").value) {
						
					allGood = true;
						
				} else {
				
					allGood = false;
					document.getElementById("message").innerHTML = "The passwords you set does not match!";
				
				}
				
				return allGood;
			}
		
		}		
	}		
}

