<style amp-custom>
    body {
        background: #F5F5F5;
        font-family: -apple-system, "Helvetica Neue", "Lucida Grande", "Verdana", "Arial", sans-serif;
    }
    .wrapper {
        max-width: 479px;
        margin: 0 auto;
        padding: 0;
        min-width: 200px;
        background: #fff;
    }
    .amp_sitelogo{
        position: relative;
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin: 0 0 25px 0;
        padding: 25px 0 0 0;
    }
    .amp_sitelogo::before{
        content: "";
        width: 27px;
        margin-right: 27px;
        height: 38px;
        background: #00A143;
    }
    .amp_sitelogo::after{
        content: "";
        width: 27px;
        margin-left: 27px;
        height: 38px;
        background: #00A143;
    }
    .fotka{
        margin-bottom: 15px;
    }
    .fotka img{
        width: 100%;
        height: 100%;
    }
    .social-and-hamburger{
        position: relative;
        display: flex;
        justify-content: center;
        align-items: center;
    }
    .social-media{
        display: flex;
        align-items: center;
    }
    .haslo{
        font-size: 17px;
        font-weight: 500;
        text-align: center;
    }
    .social-media a{
        height: 30px;
        margin: 0 3px;
    }
    .logo{
        width: calc(100% - 60px);
    }
    .logo img{
        width: 50%;
    }
    .article>.content-art {
        width: 100%;
    }
    .article{
        margin: 30px 15px 20px 15px;
    }
    .article h2{
        margin: 15px 0 15px 0px;
        font-size: 24px;
        line-height: 1.54;
        word-wrap: break-word;
    }
    .article h3{
        margin: 15px 0 15px 0px;
        font-size: 22px;
        line-height: 1.54;
        word-wrap: break-word;
    }
    .article h4{
        margin: 15px 0 15px 0px;
        font-size: 20px;
        line-height: 1.54;
        word-wrap: break-word;
    }
    .tresc p {
        font-size: 16px;
        margin-top: 5px;
        margin-bottom: 15px;
        text-align: left;
        line-height: 1.9;
        word-wrap: break-word;
        word-break: break-word;
    }
    .tresc p:first-child {
        font-size: 20px;
        line-height: 27px;
        font-weight: 700;
        word-wrap: break-word;
    }
    .nav-list{
        margin-top: 10px;
        margin-bottom: 10px;
    }
    .hamburger_wrapper {
        padding: 0px;
        z-index: 10;
        height: 25px;
    }
    #hamburger {
        width: 29px;
        height: 25px;
        position: absolute;
        right: 20px;
        cursor: pointer;
        outline: none;
        margin-left: auto;
    }
    #hamburger span {
        display: block;
        position: absolute;
        height: 4px;
        width: 100%;
        background: #000;
        border-radius: 9px;
        opacity: 1;
        left: 0;
        transform: rotate(0deg);
        transition: .5s ease-in-out;
    }
    #hamburger span:nth-child(1) {
        top: 0px;
        transform-origin: left center;
    }
    #hamburger span:nth-child(2) {
        top: 10px;
        transform-origin: left center;
    }
    #hamburger span:nth-child(3) {
        top: 20px;
        transform-origin: left center;
    }
    #hamburger.close span:nth-child(1) {
        transform: rotate(45deg);
    }
    #hamburger.close span:nth-child(2) {
        width: 0%;
        opacity: 0;
        transition: .1s;
    }
    #hamburger.close span:nth-child(3) {
        transform: rotate(-45deg);
    }
    #nav-menu {
        position: relative;
        /* opacity: 0; */
        display: none;
        height: 0px;
        z-index: 10;
    }
    #nav-menu.now-active {
        /* opacity: 1; */
        display: block;
        height: 100%;
        background-color: #fff;
    }
    ol a{
        color: #000;
    }
    .nav.menu.mod-list{
        padding: 10px 0;
        list-style: none;
        display: flex;
        text-align: center;
        flex-direction: column;
        justify-content: center;
        align-items: center;
    }
    .nav-child {
        list-style: none;
        padding: 0 0 0 0;
    }
    .nav-list {
        padding: 10px;
        list-style-type: none;
        font-size: 2em;
    }
    .haslo p{
        margin-bottom: 0px;
    }

    .author{
        font-size: 11px;
    }
    .content-art h1{
        margin: 5px 0 15px 0px;
        font-size: 30px;
        line-height: 1.14;
        font-weight: 700;
    }
    footer{
        background-color: #171717;
    }
    footer>#footer{
        font-size: 13px;
        text-align: center;
        padding: 15px 0;
        background: #171717;
        color: #8f8f8f;
        margin-top: 0px;
        width: 80%;
        margin: 0 auto;
    }
    .powrot{
        padding-bottom: 15px;
        text-align: center;
    }
    .powrot a{
        color: #fff;
        border: 1px solid #fff;
        padding: 5px;
        border-radius: 9px;
        text-decoration: none;
    }
    .tresc img{
        width: 100%;
        height: auto;
    }
    .kafelki {
        display: flex;
        background: #fff;
        padding-top: 20px;
        grid-column: 2;
        padding-left: 15px;
        padding-right: 15px;
        flex-wrap: wrap;
        justify-content: space-between;
    }

    .kafelek {
        width: 100%;
        margin-bottom: 20px;
        position: relative;
        webkit-box-shadow: 0px 0px 10px 3px rgb(0 0 0 / 5%);
        -moz-box-shadow: 0px 0px 10px 3px rgba(0, 0, 0, 0.05);
        box-shadow: 0px 0px 10px 3px rgb(0 0 0 / 5%);
    }

    .kafelek img {
        width: 100%;
    }

    .kafelek>.tytul h2 {
        color: #404040;
        font-size: 16px;
        padding-left: 15px;
        display: block;
        letter-spacing: 0.2px;
        padding-right: 15px;
        padding-bottom: 5px;
        padding-top: 15px;
        font-weight: bold;
        margin-top: 0px;
    }

    .kafelek a {
        color: #000;
        text-decoration: none;
    }

    .firstartincategory {
        /* display: grid; */
        /* flex-wrap: nowrap; */
        overflow: hidden;
        background: #171717;
        /* grid-template-columns: 50% 50%; */
        margin: 0px 15px 0 15px;
    }
    .textOffFirstArt {
        padding: 10px;
    }
    .textOffFirstArt h2 {
        color: #fff;
        font-size: 20px;
        display: block;
        letter-spacing: 0.2px;
        padding-right: 15px;
        padding-bottom: 5px;
        padding-top: 15px;
        font-weight: bold;
    }
    .textOffFirstArt a {
        color: #fff;
        text-decoration: none;
    }
    .textOffFirstArt .wstepik {
        color: white;
        padding-bottom: 25px;
    }
</style>
