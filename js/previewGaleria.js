let uploadButton = document.getElementById
("upload-button");
let chosenImage = document.getElementById
("chosen-image");
let fileName = document.getElementById
("file-name");


uploadButton.onchange = () => {
    let reader = new FileReader();
    reader.readAsDataURL(uploadButton.files[0]);
    console.log(uploadButton.files[0]);
    reader.onload = () => {
        chosenImage.setAttribute("src", reader.result);
    }
    fileName.textContent = uploadButton.files[0].name;
}





let uploadButton2 = document.getElementById
("upload-button2");
let chosenImage2 = document.getElementById
("chosen-image2");
let fileName2 = document.getElementById
("file-name2");


uploadButton2.onchange = () => {
    let reader2 = new FileReader();
    reader2.readAsDataURL(uploadButton2.files[0]);
    console.log(uploadButton2.files[0]);
    reader2.onload = () => {
        chosenImage2.setAttribute("src", reader2.result);
    }
    fileName2.textContent = uploadButton2.files[0].name;
}







let uploadButton3 = document.getElementById
("upload-button3");
let chosenImage3 = document.getElementById
("chosen-image3");
let fileName3 = document.getElementById
("file-name3");


uploadButton3.onchange = () => {
    let reader3 = new FileReader();
    reader3.readAsDataURL(uploadButton3.files[0]);
    console.log(uploadButton3.files[0]);
    reader3.onload = () => {
        chosenImage3.setAttribute("src", reader3.result);
    }
    fileName3.textContent = uploadButton3.files[0].name;
}




let uploadButton4 = document.getElementById
("upload-button4");
let chosenImage4 = document.getElementById
("chosen-image4");
let fileName4 = document.getElementById
("file-name4");


uploadButton4.onchange = () => {
    let reader4 = new FileReader();
    reader4.readAsDataURL(uploadButton4.files[0]);
    console.log(uploadButton4.files[0]);
    reader4.onload = () => {
        chosenImage4.setAttribute("src", reader4.result);
    }
    fileName4.textContent = uploadButton4.files[0].name;
}




let uploadButton5 = document.getElementById
("upload-button5");
let chosenImage5 = document.getElementById
("chosen-image5");
let fileName5 = document.getElementById
("file-name5");


uploadButton5.onchange = () => {
    let reader5 = new FileReader();
    reader5.readAsDataURL(uploadButton5.files[0]);
    console.log(uploadButton5.files[0]);
    reader5.onload = () => {
        chosenImage5.setAttribute("src", reader5.result);
    }
    fileName5.textContent = uploadButton5.files[0].name;
}





let uploadButton6 = document.getElementById
("upload-button6");
let chosenImage6 = document.getElementById
("chosen-image6");
let fileName6 = document.getElementById
("file-name6");


uploadButton6.onchange = () => {
    let reader6 = new FileReader();
    reader6.readAsDataURL(uploadButton6.files[0]);
    console.log(uploadButton6.files[0]);
    reader6.onload = () => {
        chosenImage6.setAttribute("src", reader6.result);
    }
    fileName6.textContent = uploadButton6.files[0].name;
}