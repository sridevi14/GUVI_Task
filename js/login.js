var session_Id = window.localStorage.getItem("session_Id");
if (session_Id) {
  var page = "./profile.html";
  window.location.href = page;
}

$(document).ready(function () {
  $("#myForm").submit(function (e) {
    e.preventDefault();
    var page = "./profile.html";

    localStorage.clear();
    $.ajax({
      url: "./php/login.php?",
      method: "POST",
      data: $("#myForm").serialize(),
      success: function (res) {
        if (res == 5) {
          $("#register_output").html("Incorrect Email or Password");
        } else {
          $("#register_output").html("You are Logged in");
          localStorage.setItem("session_Id", res);
          window.location.href = page;
        }
      },
    });
  });
});
