
function onclickbtn(){

  var allinputs =document.querySelectorAll(".inputSame");
  allinputs.forEach(singleinput =>singleinput.value="");


}
function changeInfo(inputInfo,toBeChanged){

  var username = document.getElementById(`${inputInfo}`);
  var changeName = document.getElementById(`${toBeChanged}`);

  var inputHandler =function(e){
    changeName.innerText =e.target.value;
  }

  username.addEventListener("input",inputHandler);
  username.addEventListener("propertychange",inputHandler);
}

changeInfo("username","name");

changeInfo("faculty","facultyy");
changeInfo("aboutme","aboutmee");



document.addEventListener("DOMContentLoaded", function() {
  var radioButtons = document.querySelectorAll('input[type="radio"]');
  radioButtons.forEach(function(radioButton) {
    radioButton.addEventListener('click', function() {
      var selectedValue = this.value;
      var outputList = document.getElementById('HobbiesUL');
      var existingItem = outputList.querySelector('li[value="' + selectedValue + '"]');
      if (existingItem) {
        existingItem.parentNode.removeChild(existingItem);
      } else {
        var newItem = document.createElement('li');
        newItem.textContent = selectedValue;
        newItem.setAttribute('value', selectedValue); // Set value attribute for future reference if needed
        outputList.appendChild(newItem);
      }
    });
  });
});

var fileInput= document.getElementById("inputFile");
var profimage = document.getElementById("profilePicture");
fileInput.addEventListener('change',function(){
  var file = this.files[0];
  if(file){
    var reader = new FileReader();
    reader.onload = function(e){
      profimage.src = e.target.result;
    }
    reader.readAsDataURL(file);
  }else{
    profimage= "#";
  }
})


document.getElementById("discard").addEventListener("click",function(e){
  e.preventDefault();
  var allinputs =document.querySelectorAll(".inputSame");
  allinputs.forEach(singleinput =>singleinput.value="");
})


