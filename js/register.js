var session_Id = window.localStorage.getItem("session_Id");
if (session_Id) {
  var page = "./profile.html";
  window.location.href = page;
}

$(document).ready(function () {
  $("#myForm").submit(function (e) {
    e.preventDefault();
    var pw1 = document.getElementById("password").value;
    var pw2 = document.getElementById("confirm_password").value;
    if (pw1 && pw1 != pw2) {
      alert("Passwords did not match");
      return;
    } else {
      e.preventDefault();
      var page = "./login.html";

      $.ajax({
        url: "./php/register.php?",
        method: "POST",
        data: $("#myForm").serialize(),
        success: function (res) {
          if (res == 2) {
            $("#register_output").html("Registered Successfully");

            window.location.href = page;
          }
          if (res == 1) {
            $("#register_output").html(" Already Exist");
          }
        },
      });
    }
  });
});
