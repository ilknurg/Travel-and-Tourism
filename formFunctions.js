
	function clearForm() {
 // document.getElementById('survey').reset();
 document.getElementById('extra').innerHTML = "";
 document.getElementById('firstName').setAttribute('value','');
 document.getElementById('lastName').setAttribute('value','');
 document.getElementById('email').setAttribute('value','');
 document.getElementById('phone').setAttribute('value','');

}

var count = 0;

function buildExtraField() {
var newId = "experience"+count;
var newElem = document.createElement("li");
     newElem.innerHTML = '<label for="' + newId + '">Class:</label><input type="text" name="experience[]" id="'+newId+'" value=""><span class="error"></span><br>'

var container = document.getElementById("extra");
container.appendChild(newElem);

document.getElementById(newId).focus();
	count++;
}
