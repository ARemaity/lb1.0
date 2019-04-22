var uid;

//TODO:get uid for the new added user

document.getElementById("register").addEventListener("click", function () {
  var email = document.getElementById("email").value;
  var password = document.getElementById("password").value;
  var repassword = document.getElementById("repassword").value;
  var city = document.getElementById("city").value;
  var street = document.getElementById("street").value;
  var phone = document.getElementById("phone").value;
  var fname = document.getElementById("fname").value;
  var lname = document.getElementById("lname").value;

  if (city === "" || fname === "" || lname === "" || street === "" || phone === "" || email === "" || password === "" || repassword === "") {
    location.reload();
    window.alert("please all fields");

  } else if (password != repassword) {
    window.alert("please renter same password");
    document.getElementById("password").innerHTML = "";
    document.getElementById("repassword").innerHTML = "";

  } else {

    firebase.auth().createUserWithEmailAndPassword(email, password)
    .then(function success(userData){
        console.log("it enter hahaha")
          uid=userData.uid;
          var xhr = new XMLHttpRequest();

          xhr.onload = function () {
    
            window.alert(this.responseText);
          };
          xhr.open("POST", 'http://localhost/lb1.0/lb1.0/newuser.php', true);
    
          //Send the proper header information along with the request
          xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
          xhr.send("uid="+uid+"&fname=" + fname + "&lname=" + lname + "&phone=" + phone + "&city=" + city + "&street=" + street + "&email=" + email);
          
    // window.alert(city+" "+street+" "+phone+" "+fname+" "+lname);
    }).catch(function (error) {
      // Handle Errors here.

      //errorExist = "TRUE";
console.log("she enter the error field");
      var errorCode = error.code;
      var errorMessage = error.message;
      window.alert("Error : " + errorMessage);
      location.reload();     // ...
    });

   
}
  
});














// xhr.send(new Int8Array()); 
// xhr.send(document);