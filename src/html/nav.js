document.getElementsByTagName("nav")[0].innerHTML = `
  <div class="nav" id="mainNav">
    <a href="home.html" id="navHome" class="navItem">
      <img class="navLogo" src="files/images/logoWhite.png" style="margin: 0px">
      <p id="home"> Home</p>
    </a>
    <a href="stores.html" id="stores" class="navItem">Stores</a>
    <a href="register.html" id="register" class="navItem">Register</a>
    <a href="login.html" id="login" class="navItem">Login</a>
    <a href="about.html" id="about" class="navItem">About</a>
    <a href="contact.html" id="contact" class="navItem">Contact</a>
    <a href="controller.html" id="controller" class="navItem">Controller</a>
    <a href="admin.html" id="admin" class="navItem">Admin</a>
    <a href="javascript:void(0);" class="icon">
      <img class="navMenu" src="files/images/menu.svg">
    </a>
  </div>
`