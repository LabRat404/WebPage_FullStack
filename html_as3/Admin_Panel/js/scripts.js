/*!
* Start Bootstrap - Shop Homepage v5.0.4 (https://startbootstrap.com/template/shop-homepage)
* Copyright 2013-2021 Start Bootstrap
* Licensed under MIT (https://github.com/StartBootstrap/startbootstrap-shop-homepage/blob/master/LICENSE)
*/
// This file is intentionally blank
// Use this file to add JavaScript to your project


//nav bar

const dropdown_btns = document.querySelectorAll(".dropdown-btn");
const burger = document.querySelector(".burger");

const inpFile = document.getElementById("file");
const previewContainer = document.getElementById("imagePreview");
const previewImage = previewContainer.querySelector(".image-preview__image");
const previewDefaultText = previewContainer.querySelector(".image-preview__default-text");


burger.addEventListener("click", () => {
  const navbar_content = document.querySelector(".navbar-content");
  burger.classList.toggle("active");

  navbar_content.classList.toggle("show");
});



dropdown_btns.forEach((btn) => {
  btn.addEventListener("click", (e) => {
    const dropdown = e.currentTarget.nextElementSibling;

    dropdown.classList.toggle("show");
    document
      .querySelectorAll(".dropdown-btn + .dropdown-list")
      .forEach((dropdown) => {
        if (dropdown !== e.currentTarget.nextElementSibling) {
          dropdown.classList.remove("show");
        }
      });
  });
});

window.onclick = (e) => {
  if (!e.target.matches(".dropdown-btn")) {
    const dropdowns = document.querySelectorAll(".dropdown-list");
    dropdowns.forEach((drpodown) => {
      drpodown.classList.remove("show");
    });
  }
};



//Drag and drop
inpFile.addEventListener("change", function(){
  const file = this.files[0];
  
  if(file){

    const reader = new FileReader();
    previewDefaultText.style.display = "none";
    previewImage.style.display = "block";

    reader.addEventListener("load", function(){
      console.log(this);
        previewImage.setAttribute("src", this.result);
    });

    reader.readAsDataURL(file);
  }else{
    previewDefaultText.style.display = null;
    previewImage.style.display =null;
    previewImage.setAttribute("src", "this.result");
  }
});


// $(document).ready(function(){

//   load_old();


//   function valid()
//   {
//     for(let i=0; i < localStorage.length;i++){
//       var pid = JSON.parse(localStorage.key(i));
//       var quantity =  JSON.parse(localStorage.getItem(pid)).quantity;
//       if(quantity <=0)
//       localStorage.removeItem(pid);
//     }
//   }


//   function load_cart_data()
//   {
//     $.ajax({
//       url:"fetch_cart.php",
//       method:"POST",
//       dataType:"json",
//       async: false,
//       success:function(data)
//       {
//         $('#cart_details').html(data.cart_details);
//         $('.total_price').text(data.total_price);
//         $('.badge').text(data.total_item);
//       }
//     });
//     valid();
//   }
  
//   function clear(){
  
//     var action = 'empty';
//     $.ajax({
//       url:"action.php",
//       method:"POST",
//       data:{action:action},
//       async: false,
//       success:function()
//       {
//         load_cart_data();
//         $('#cart-popover').popover('hide');
//       }
//     });
//     valid();
//   }


//   function load_old()
//   {
//     //resets the cart
//     clear();
//     //load the old cart
//     console.log("aaaa" + localStorage.length);
//     for(let i=0; i < localStorage.length;i++){
//       var pid = JSON.parse(localStorage.key(i));
//       var name = JSON.parse(localStorage.getItem(pid)).name;
//       var price =  JSON.parse(localStorage.getItem(pid)).price;
//       var quantity =  JSON.parse(localStorage.getItem(pid)).quantity;
//       console.log("pidd" + pid + name + price + " qun" + quantity);
//       for(let i=0; i < 50000000; i++)
//       {}
//       if(quantity!=null){
//         var action = "add";
//         $.ajax({
//           url:"action.php",
//           method:"POST",
//           async: false,
//           data:{pid:pid, name:name, price:price, quantity:quantity, action:action},
//           success:function(data)
//           {
//             load_cart_data();
//           }
//         });
//       } 
//     } 
//     console.log("okk");
//     valid();
//   }
  
//   $(document).on('click', '.minus', function(){
  
//     var pid = $(this).attr("id");
//     var name = document.getElementById("name" + pid).value;
//     var price = document.getElementById("price" + pid).value;
//     var quantity = document.getElementById("quantity" + pid).value;
//     var action = "add";
//     var oldcart = JSON.parse(localStorage.getItem(pid));
//     if(oldcart != null)
//     var oldquan = JSON.parse(localStorage.getItem(pid)).quantity;
//     oldquan -= 1;
  
//     var data ={pid:pid, name:name, price:price, quantity:oldquan};
  
   
//     var action = "add";
//     data ={pid:pid, name:name, price:price, quantity:oldquan};
//     localStorage.setItem(pid, JSON.stringify(data));
//     $.ajax({
//       url:"action.php",
//       method:"POST",
//       async: false,
//       data:{pid:pid, name:name, price:price, quantity:-1, action:action},
//       success:function(data)
//       {
//         load_cart_data();
  
//       }
//     });
    
//     console.log("item minussss");
//     valid();
//   });
  
//   function minus(pid){


//     var name = document.getElementById("name" + pid).value;
//     var price = document.getElementById("price" + pid).value;
//     var quantity = document.getElementById("quantity" + pid).value;
//     var action = "add";
//     var oldcart = JSON.parse(localStorage.getItem(pid));
//     if(oldcart != null)
//     var oldquan = JSON.parse(localStorage.getItem(pid)).quantity;
//     oldquan -= 1;
  
//     var data ={pid:pid, name:name, price:price, quantity:oldquan};
  
   
//     var action = "add";
//     data ={pid:pid, name:name, price:price, quantity:oldquan};
//     localStorage.setItem(pid, JSON.stringify(data));
//     $.ajax({
//       url:"action.php",
//       method:"POST",
//       async: false,
//       data:{pid:pid, name:name, price:price, quantity:-1, action:action},
//       success:function(data)
//       {
//         load_cart_data();
  
//       }
//     });
    
//     console.log("item minussss");
//     valid();

//   }


//   $(document).on('click', '.add_to_cart', function(){
    
//     var pid = $(this).attr("id");
//     var name = document.getElementById("name" + pid).value;
//     var price = document.getElementById("price" + pid).value;
//     var quantity = document.getElementById("quantity" + pid).value;
//     var action = "add";
  
//     var oldcart = JSON.parse(localStorage.getItem(pid));
//     if(oldcart != null)
//     var oldquan = JSON.parse(localStorage.getItem(pid)).quantity;
//     console.log("oldcart quan = " + oldquan);
  
//     var data ={pid:pid, name:name, price:price, quantity:quantity};
    
//     if(oldquan == 0 ||oldquan == null){
//     localStorage.setItem(pid, JSON.stringify(data));
//     }else{
//     data ={pid:pid, name:name, price:price, quantity:++oldquan};
//     localStorage.setItem(pid, JSON.stringify(data));
//     }
  
//     if(quantity > 0)
//     {
  
//       $.ajax({
//         url:"action.php",
//         method:"POST",
//         async: false,
//         data:{pid:pid, name:name, price:price, quantity:quantity, action:action},
//         success:function(data)
//         {
//           load_cart_data();
          
//         }
//       });

//     }
//     else
//     {
//       alert("Error");
//       window.location.replace("http://52.205.222.173/Public/index.php#");
//     }
//     valid();
//   });
  
//   $(document).on('click', '.btn-close', function(){
   
//     var pid = $(this).attr("id");
//     var oldcart = JSON.parse(localStorage.getItem(pid));
//     if(oldcart != null)
//     var oldquan = JSON.parse(localStorage.getItem(pid)).quantity;
//     for(let j = oldquan; j>0; j--)
//     minus(pid);


//     console.log("item minussss");
//     valid();
//   });
  
//   $(document).on('click', '#clear_cart', function(){
//     var action = 'empty';
//     $.ajax({
//       url:"action.php",
//       method:"POST",
//       data:{action:action},
//       success:function()
//       {
//         load_cart_data();
//         $('#cart-popover').popover('hide');
//         alert("Your Cart has been clear");
//       }
//     });
  
//     localStorage.clear();
//     $('#cart-popover').popover('hide');
//     valid();
//   });
//   valid();
// // });