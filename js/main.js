$(document).ready(function(){

//bootstrap tooltips
$('[data-toggle="tooltip"]').tooltip(); 

//user action
$(".click_repo").click(function(){
  var repo_name = $(this).text();
  $.post( "db.php", { name: repo_name, action: "clicked", data: "repository" } );
});

//user action
$(".open_issues").click(function(){
  var issues = $(this).text();
  $.post( "db.php", { name: issues, action: "opened", data: "page" } );
});

//user action
$(".click_issue").click(function(){
  var issue = $(this).text();
  $.post( "db.php", { name: issue, action: "clicked", data: "issue" } );
});

//
  $("#submit").click(function(e) {
    e.preventDefault();
    var min_value = 5;

    //min value 5 chars for Github
    if ( $("#login").val().length < min_value) {
        alert("min amount login chars - " + min_value);
        return false;
    }
    var form_data = $("#form").serialize();

    //Loader.gif 
    $(".overlay").css({"opacity":"1", "visibility":"visible"});
    $("#loader").css("display", "block");
    $.ajax({
        type: "POST",
        url: "functions.php",
        data: form_data,
        success: function(data) {
          if ( data == false){
            $(".overlay").css({"opacity":"0", "visibility":"hidden"});
            $("#loader").css("display", "none");
            alert("Please enter correct login or password");
          } else {
            window.location.reload();
          }
        }
    });
  });
});