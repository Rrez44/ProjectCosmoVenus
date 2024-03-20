

  document.getElementById("changeInformation").addEventListener("submit",function(event){
    event.preventDefault();

    const formData = new FormData(event.target);

    const username = formData.get("username");
    const faculty = formData.get("faculty");
    const aboutme = formData.get("aboutme")
    const profilePicture = formData.get("inputfile")

    const getu = URL.createObjectURL(profilePicture);
    console.log(getu)

    if(username !=""){
    const changeUsername = document.getElementById("name");
    changeUsername.innerHTML = username;
    }
    if(faculty !=""){
    const changeFaculty = document.getElementById("facultyy");
    changeFaculty.innerHTML = faculty;
    }
    if(aboutme !=""){
    const changeAboutMe = document.getElementById("aboutmee")
    changeAboutMe.innerHTML =aboutme;
    }
    console.log(profilePicture)
    if(profilePicture.name !=""){

    const changeProfile =document.getElementById("profilePicture");
    changeProfile.src =getu;
    }
    console.log(getu);
    
    var allinputs =document.querySelectorAll(".inputSame");
    allinputs.forEach(singleinput =>singleinput.value="");
 
  });
  var clickCount={};

  var appentToThisList = document.getElementById("HobbiesUL");
  $(".hobbiesSelected").click(function(){
    console.log($(this).val())
    var value =$(this).val();
    if(clickCount[value] && clickCount[value] === 1){
        $("#HobbiesUL li:contains(" + value + ")").remove();
        console.log("hello");
        clickCount[value] =0;
    }else{
    var listItem = document.createElement("li");
    listItem.appendChild(document.createTextNode($(this).val()))
    appentToThisList.append(listItem)
    clickCount[value] = clickCount[value] ? clickCount[value] + 1 : 1;
    console.log(clickCount[value])
    }
  })


  function onclickbtn(){
    var allinputs =document.querySelectorAll(".inputSame");
    allinputs.forEach(singleinput =>singleinput.value="");
 

  }