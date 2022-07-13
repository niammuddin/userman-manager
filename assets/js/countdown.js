// CountDown Time & Date
// Version : v1.0
// Last Update : 28 Januari 2020
var countDownDate = new Date("Dec 26, 2019 21:00:00").getTime();
var x = setInterval(function() {
var now = new Date().getTime();
var distance = countDownDate - now;
var days = Math.floor(distance / (1000 * 60 * 60 * 24));
var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
var seconds = Math.floor((distance % (1000 * 60)) / 1000);
document.getElementById("time").innerHTML ="Cooming Soon at " + hours + "h "
+ minutes + "m " + seconds + "s ";
if (distance < 0) {
  clearInterval(x);
  document.getElementById("time").innerHTML = "Order Now";
}
}, 1000);
