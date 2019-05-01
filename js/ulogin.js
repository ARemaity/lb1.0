 
  firebase.auth().onAuthStateChanged(function(user) {
    if (user) {
    //  document.getElementById("user_div").style.display = "block";//..this to show the elemet
      document.getElementById("login_div").style.display = "none";//..THIS FOR TO hide the elemnet
      var user = firebase.auth().currentUser;
     
  //$.post( "test.php", { id: io } );
  //
      if(user != null){
        var io=user.uid;
      var str="http://localhost/lb1.0/lb1.0/ulogin.php?id="+io;
      //window.alert(str);
      window.location.replace(str);
      
        //var email_id = user.email;
       // document.getElementById("user_para").innerHTML = "Welcome User : " + email_id;
  
      }
  
    } else {
      // No user is signed in.
  
    //  document.getElementById("user_div").style.display = "none";
      document.getElementById("login_div").style.display = "block";
  
    }
  });
  
  function login(){
  
    var userEmail = document.getElementById("email_field").value;
    var userPass = document.getElementById("password_field").value;
    console.log(userEmail);
         firebase.auth().signInWithEmailAndPassword(userEmail, userPass).catch(function(error) {
      // Handle Errors here.
      var errorCode = error.code;
      var errorMessage = error.message;
  
      window.alert("Error : " + errorMessage);
  
      // ...
    });
  
  }
  
  function logout(){
    firebase.auth().signOut();
  }
  