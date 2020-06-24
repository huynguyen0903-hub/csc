function openNav() {
  document.getElementById("mySidenav").style.width = "250px";
}
function closeNav() {
  document.getElementById("mySidenav").style.width = "0";
}
$(".collapse").collapse();
$(".btn-outline-warning").click(function(event) {
  imgSrc = $(this)
    .parent()
    .attr("isc");
  $(".image")
    .find("img")
    .attr("src", imgSrc.context);
  event.preventDefault();
});
