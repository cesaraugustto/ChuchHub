<style>
    *{
        padding: 0;
        margin: 0;
        box-sizing: border-box;
    }

    .container{
        
        height: 255px;
        max-height: 255px;
        transform: translate(17px 88px 0px);
    }

    .image-container{
        width: 100%;
    }
    .image-container img{
        display: block;
        position: relative;
        max-height: 150px;
        margin: auto;
        box-shadow: 3px 5px 10px rgba(0,0,0,0.3);
    }
    figcaption{
        text-align: center;
        color: transparent;
    }
    input[type="file"]{
        display: none;
    }
    .labelFoto{
        display:block;
        position: relative;
        background-color: cadetblue;
        color: #ffffff;
        font-size: 16px;
        text-align: center;
        width: 100%;
        cursor: pointer;
    }
</style>