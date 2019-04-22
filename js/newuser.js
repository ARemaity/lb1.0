var errorExist = "FALSE";


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

    // window.alert(city+" "+street+" "+phone+" "+fname+" "+lname);
    auth.createUserWithEmailAndPassword(email, password).catch(function (error) {
      // Handle Errors here.

      errorExist = "TRUE";
console.log("first error is "+errorExist);
      var errorCode = error.code;
      var errorMessage = error.message;
      window.alert("Error : " + errorMessage);
      location.reload();     // ...
    });

    window.setTimeout(insert,1000);
    /////////////////
    //var user=firebase.auth().currentUser;
    //var id=user.uid;
    //var str="http://localhost/firebaseWebLogin/newuser.php?id="+io;
    //window.alert(id);
function insert(){

    if (errorExist == "FALSE") {
      console.log("secod error is"+errorExist);
      var user = firebase.auth().currentUser;
      //var id = user.uid;

      //  console.log(id);
      var xhr = new XMLHttpRequest();

      xhr.onload = function () {

        window.alert(this.responseText);
      };
      xhr.open("POST", 'http://localhost/lb1.0/lb1.0/newuser.php', true);

      //Send the proper header information along with the request
      xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
      xhr.send("fname=" + fname + "&lname=" + lname + "&phone=" + phone + "&city=" + city + "&street=" + street + "&email=" + email);
    }
}
  }
});














// xhr.send(new Int8Array()); 
// xhr.send(document);