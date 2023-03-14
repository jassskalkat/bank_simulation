window.addEventListener("load",start,false);
function start(){
    var time = new Date();
    var hour = time.getHours();
    greeting(hour);
    var addFunds = document.getElementById("addFunds");
    var withdrawFunds = document.getElementById("withdrawFunds");
    addFunds.onsubmit = addAlert;
    withdrawFunds.onsubmit = withdrawAlert;
}
//return false and it wont send form to php
function addAlert(){
    let number = window.prompt("How much money would you like to add");
    if(number == null){
        return false;
    }
    if(number<0){
        alert("Do not use negative signs when entering the amount");
        return false;
    }
    if(number>=10000){
        alert("cannot add 10000 or more at once!");
        return false;
    }
    try{
        let asyncRequest = new XMLHttpRequest();
        asyncRequest.addEventListener("readystatechange",function(){
            if(asyncRequest.readyState == 4){
                if(asyncRequest.status == 200){
                    document.getElementById("balance").innerHTML = "$"+asyncRequest.responseText;// response text is what is written on the changeFunds page(printline at the end)
                    alert("account balance has been successfully added");
                }
                else if(asyncRequest.status == 400){
                    alert("Invalid input");
                }
                else{
                    alert("Unknown error has occured");
                }
            }
            
        },false);
        asyncRequest.open("POST","api/changeFunds.php",true);
        asyncRequest.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
        asyncRequest.send("amount="+number);// amount is the $POST variable in the changefunds  file

    }
    catch(exception){
        alert("Request Failed.");
    }
    return false;
}


function withdrawAlert(){
    let number = window.prompt("How much would you like to withdraw");
    if(number == null){
        return false;
    }
    if(number<0){
        alert("Do not use negative signs when entering the amount");
        return false;
    }
    if(number>accountBalance){
        alert("cannot withdraw more than you have");
        return false;
    }
    try{
        let asyncRequest = new XMLHttpRequest();
        asyncRequest.addEventListener("readystatechange",function(){
            if(asyncRequest.readyState == 4){
                if(asyncRequest.status == 200){
                    document.getElementById("balance").innerHTML = "$"+asyncRequest.responseText;// response text is what is written on the changeFunds page(printline at the end)
                    alert("account balance has been successfully withdrawn");
                    if(number>=10000){
                        alert("We are contacting the IRS to see what you are doing with that large withdrawl!");
                    }
                }
                else if(asyncRequest.status == 400){
                    alert("Invalid input");
                }
                else{
                    alert("Unknown error has occured");
                }
            }
            
        },false);
        asyncRequest.open("POST","api/changeFunds.php",true);
        asyncRequest.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
        asyncRequest.send("amount="+(-number));// amount is the $POST variable in the changefunds  file
    }
    catch(exception){
        alert("Request Failed.");
    }
    return false;
}

function greeting(hour){
    var greeting = document.getElementById("greeting");
    if(hour<12){
        greeting.innerHTML = "Good morning ";
    }
    else if(hour <18){
        greeting.innerHTML = "Good afternoon "
    }
    else{
        greeting.innerHTML = "Good evening ";
    }
}