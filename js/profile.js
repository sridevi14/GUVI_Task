var session_Id = window.localStorage.getItem("session_Id");
if (!session_Id) {
  var page = "./login.html";
  window.location.href = page;
}
$(document).ready(function () {
  $.ajax({
    method: "POST",
    url: "./php/profile.php?",
    data: { myData: session_Id },
    success: function (res) {
      if (res) {
        var form_value = JSON.parse(res);
        document.getElementById("name").value = form_value.name;
        document.getElementById("email").value = form_value.email;
        document.getElementById("dob").value = form_value.dob;
        document.getElementById("address").value = form_value.address;
        document.getElementById("profile").innerHTML =
          "Welcome " + form_value.name + "!";
      }
    },
  });

  $("#myForm").submit(function (e) {
    e.preventDefault();
    $.ajax({
      url: "./php/profile.php?session_Id=" + session_Id,
      method: "POST",
      data: $("#myForm").serialize(),
      success: function (res) {
        alert("updated");
      },
    });
  });
});

function logout() {
  localStorage.clear();
  $.ajax({
    url: "./php/profile.php?session_Id=" + session_Id,
    method: "GET",
    success: function (res) {
      alert("logged out");
    },
  });
  var page = "./login.html";
  window.location.href = page;
}
