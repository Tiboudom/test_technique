window.onload = function() {
    setCheckImg();
    let loading = document.getElementById("loader");
    loading.style.opacity = 1;
}

function setCheckImg()
{
    $('[id^="tableData-"]').each(function(){
        var id = $(this).attr('id');
        res = id.split("-");

        $(this).find('td').each(function(){
                if (document.getElementById("invoice-" + res[1]).innerText === "1") {
                    document.getElementById("invoice-" + res[1]).innerHTML = '<img src="/images/check.svg" alt="Invoiced" style="height: 26px; width: 26px;"/>';
                }
                if (document.getElementById("done-" + res[1]).innerText === "1") {
                    document.getElementById("done-" + res[1]).innerHTML = '<img src="/images/check.svg" alt="Done" style="height: 26px; width: 26px;"/>';
                }
        })
    })
}

function invoiceAjax(task_id)
{
    $.ajax({
        url:"/ajax_invoice",
        type: "POST",
        dataType: "json",
        data: {
            "task_id": task_id
        },
        async: true,
        success: function (data)
        {
            var test = JSON.stringify(data)
            res = test.split("\"");
            var invoiceId = "invoice-" + task_id;
            if (res[1] === "true") {
                document.getElementById(invoiceId).innerHTML = '<img src="/images/check.svg" alt="Done" style="height: 26px; width: 26px;"/>';
            } else {
                document.getElementById(invoiceId).innerText = "";
                
            }
            return true;
        }
    });
    return false;
}

function doneAjax(task_id)
{
    $.ajax({
        url:"/ajax_done",
        type: "POST",
        dataType: "json",
        data: {
            "task_id": task_id
        },
        async: true,
        success: function (data)
        {
            var test = JSON.stringify(data)
            res = test.split("\"");
            var doneId = "done-" + task_id;
            if (res[1] === "true") {
                document.getElementById(doneId).innerHTML = '<img src="/images/check.svg" alt="Done" style="height: 26px; width: 26px;"/>';
                let tmp = document.getElementById("tasksDone").innerHTML;
                document.getElementById("tasksDone").innerHTML = Number(tmp) + 1;
            } else {
                document.getElementById(doneId).innerText = "";
                let tmp = document.getElementById("tasksDone").innerHTML;
                document.getElementById("tasksDone").innerHTML = Number(tmp) - 1;
            }
            return true;
        }
    });
    return false;
}