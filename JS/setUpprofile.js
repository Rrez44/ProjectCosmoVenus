

  // document.getElementById("changeInformation").addEventListener("submit",function(event){
  //   event.preventDefault();
  //   console.log("Form submited");

  //   const formData = new FormData(event.target);

  //   const username = formData.get("username");
  //   const faculty = formData.get("faculty");
  //   const aboutme = formData.get("aboutme")
  //   const profilePicture = formData.get("inputfile")

  //   const getu = URL.createObjectURL(profilePicture);
  //   console.log(getu)
  //   console.log(username);
  //   if(username !=""){
  //   const changeUsername = document.getElementById("name");
  //   changeUsername.innerHTML = username;
  //   }
  //   if(faculty !=""){
  //   const changeFaculty = document.getElementById("facultyy");
  //   changeFaculty.innerHTML = faculty;
  //   }
  //   if(aboutme !=""){
  //   const changeAboutMe = document.getElementById("aboutmee")
  //   changeAboutMe.innerHTML =aboutme;
  //   }
  //   console.log(profilePicture)
  //   if(profilePicture.name !=""){

  //   const changeProfile =document.getElementById("profilePicture");
  //   changeProfile.src =getu;
  //   }
  //   console.log(getu);
    
  //   var allinputs =document.querySelectorAll(".inputSame");
  //   allinputs.forEach(singleinput =>singleinput.value="");
  //   this.submit();
  // // });
  // var clickCount={};

  // var appentToThisList = document.getElementById("HobbiesUL");
  // $("a25").click(function(){
  //   console.log($(this).val())
  //   var value =$(this).val();
  //   if(clickCount[value] && clickCount[value] === 1){
  //       $("#HobbiesUL li:contains(" + value + ")").remove();
  //       console.log("hello");
  //       clickCount[value] =0;
  //   }else{
  //   var listItem = document.createElement("li");
  //   listItem.appendChild(document.createTextNode($(this).val()))
  //   appentToThisList.append(listItem)
  //   clickCount[value] = clickCount[value] ? clickCount[value] + 1 : 1;
  //   console.log(clickCount[value])
  //   }
  // })


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


  