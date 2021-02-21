window.onload = function() {
    getTaskTime();
}

function getTaskTime()
{
    let totalTime = document.getElementById("totalTime").innerText;
    let res = totalTime.split("-");
    if (Number(res[3]) === 12)  {
        res[3] = 0;
    }
    let date1 = new Date(Number(res[0]), Number(res[1]), Number(res[2]), Number(res[3]), Number(res[4]), 0);
    let averageTime = document.getElementById("averageTime").innerText;
    res = averageTime.split("-");
    if (Number(res[3]) === 12)  {
        res[3] = 0;
    }
    let date2 = new Date(Number(res[0]), Number(res[1]), Number(res[2]), Number(res[3]), Number(res[4]), 0);
    let dayDiff = Math.round((date2-date1)/(1000*60*60*24));
    if (dayDiff > 0) {
        var hourDiff = Math.round(((date2-date1)/1000)/3600 / 24 * 7);
    } else {
        var hourDiff = ((date2-date1)/1000)/3600;
    }
    document.getElementById("totalTime").innerText = dayDiff + " Days";
    document.getElementById("averageTime").innerText = hourDiff + "  Hours";
    let loading = document.getElementById("loader");
    loading.style.opacity = 1;
}