//TODO:get uid for the new added user
//TODO:check if the error received to prevent inertion to the php
document.getElementById("register").addEventListener("click", function () {
  var email = document.getElementById("email").value;
  var password = document.getElementById("password").value;
  var city = document.getElementById("city").value;
  var street = document.getElementById("street").value;
  var phone = document.getElementById("phone").value;
  var fname = document.getElementById("fname").value;
  var lname = document.getElementById("lname").value;
  // window.alert(city+" "+street+" "+phone+" "+fname+" "+lname);
  auth.createUserWithEmailAndPassword(email, password).catch(function (error) {
    // Handle Errors here.
    var errorCode = error.code;
    var errorMessage = error.message;

    window.alert("Error : " + errorMessage);

    // ...
  });
  /////////////////
  //var user=firebase.auth().currentUser;
  //var id=user.uid;
  //var str="http://localhost/firebaseWebLogin/newuser.php?id="+io;
  //window.alert(id);
  var user = firebase.auth().currentUser;
  //var id = user.uid;
  if (user != null) {
    console.log(id);
    var xhr = new XMLHttpRequest();

    xhr.onload = function () {

      window.alert(this.responseText);
    };
    xhr.open("POST", 'http://localhost/firebaseWebLogin/test.php', true);

    //Send the proper header information along with the request
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xhr.send("fname=" + fname + "&lname=" + lname + "&phone=" + phone + "&city=" + city + "&street=" + street + "&email=" + email);
    //xhr.send("id="+id+"&email="+email+"&password="+password+"&fname="+fname+"&lname="+lname+"&street="+street+"&city="+city+"&phone="+phone);              
    //var id=user.uid;
    //var str="http://localhost/firebaseWebLogin/newuser.php?id="+io;
    //window.alert(str);
    //window.location.replace(str);


  } else {

    window.alert("there is problem repeat the proccess");


  }


});














// xhr.send(new Int8Array()); 
// xhr.send(document);