/*!
* Start Bootstrap - Shop Homepage v5.0.4 (https://startbootstrap.com/template/shop-homepage)
* Copyright 2013-2021 Start Bootstrap
* Licensed under MIT (https://github.com/StartBootstrap/startbootstrap-shop-homepage/blob/master/LICENSE)
*/
// This file is intentionally blank
// Use this file to add JavaScript to your project


//infinite scroll
if(document.getElementById("666GGG")){
  let ias = new InfiniteAjaxScroll('.card-container', {
    item: '.item',
    next: '.next',
    pagination: '.pagination'
  });
}


//nav bar

const dropdown_btns = document.querySelectorAll(".dropdown-btn");
const burger = document.querySelector(".burger");
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



// $(document).ready(function(){

  load_old();
  check_empty();

  function  check_empty()
  {
   
    if(localStorage.length == 0){
      document.getElementById("clear_cart").style.display = "none";
      document.getElementById("checkout").style.display = "none";
    }else{
      document.getElementById("clear_cart").style.display = "block";
      document.getElementById("checkout").style.display = "block";
    }
  }

  function valid()
  {
   
    for(let i=0; i < localStorage.length;i++){
      var pid = JSON.parse(localStorage.key(i));
      var quantity =  JSON.parse(localStorage.getItem(pid)).quantity;
      if(quantity <=0)
      localStorage.removeItem(pid);
    }
    check_empty();
  }


  function load_cart_data()
  {
    $.ajax({
      url:"fetch_cart.php",
      method:"POST",
      dataType:"json",
      async: false,
      success:function(data)
      {
        $('#cart_details').html(data.cart_details);
        $('.total_price').text(data.total_price);
        $('.badge').text(data.total_item);
      }
    });
    valid();
  }
  
  function clear(){
  
    var action = 'empty';
    $.ajax({
      url:"action.php",
      method:"POST",
      data:{action:action},
      async: false,
      success:function()
      {
        load_cart_data();
        $('#cart-popover').popover('hide');
      }
    });
    valid();
  }


  function load_old()
  {
    //resets the cart
    clear();
    //load the old cart
    console.log("aaaa" + localStorage.length);
    for(let i=0; i < localStorage.length;i++){
      var pid = JSON.parse(localStorage.key(i));
      var name = JSON.parse(localStorage.getItem(pid)).name;
      var price =  JSON.parse(localStorage.getItem(pid)).price;
      var quantity =  JSON.parse(localStorage.getItem(pid)).quantity;
      console.log("pidd" + pid + name + price + " qun" + quantity);
      for(let i=0; i < 50000000; i++)
      {}
      if(quantity!=null){
        var action = "add";
        $.ajax({
          url:"action.php",
          method:"POST",
          async: false,
          data:{pid:pid, name:name, price:price, quantity:quantity, action:action},
          success:function(data)
          {
            load_cart_data();
          }
        });
      } 
    } 
    console.log("okk");
    valid();
  }
  
  $(document).on('click', '.minus', function(){
  
    var pid = $(this).attr("id");
    var name = document.getElementById("name" + pid).value;
    var price = document.getElementById("price" + pid).value;
    var quantity = document.getElementById("quantity" + pid).value;
    var action = "add";
    var oldcart = JSON.parse(localStorage.getItem(pid));
    if(oldcart != null)
    var oldquan = JSON.parse(localStorage.getItem(pid)).quantity;
    oldquan -= 1;
  
    var data ={pid:pid, name:name, price:price, quantity:oldquan};
  
   
    var action = "add";
    data ={pid:pid, name:name, price:price, quantity:oldquan};
    localStorage.setItem(pid, JSON.stringify(data));
    $.ajax({
      url:"action.php",
      method:"POST",
      async: false,
      data:{pid:pid, name:name, price:price, quantity:-1, action:action},
      success:function(data)
      {
        load_cart_data();
  
      }
    });
    
    console.log("item minussss");
    valid();
  });
  
  function minus(pid){


    var name = document.getElementById("name" + pid).value;
    var price = document.getElementById("price" + pid).value;
    var quantity = document.getElementById("quantity" + pid).value;
    var action = "add";
    var oldcart = JSON.parse(localStorage.getItem(pid));
    if(oldcart != null)
    var oldquan = JSON.parse(localStorage.getItem(pid)).quantity;
    oldquan -= 1;
  
    var data ={pid:pid, name:name, price:price, quantity:oldquan};
  
   
    var action = "add";
    data ={pid:pid, name:name, price:price, quantity:oldquan};
    localStorage.setItem(pid, JSON.stringify(data));
    $.ajax({
      url:"action.php",
      method:"POST",
      async: false,
      data:{pid:pid, name:name, price:price, quantity:-1, action:action},
      success:function(data)
      {
        load_cart_data();
  
      }
    });
    
    console.log("item minussss");
    valid();

  }


  $(document).on('click', '.add_to_cart', function(){
    
    var pid = $(this).attr("id");
    var name = document.getElementById("name" + pid).value;
    var price = document.getElementById("price" + pid).value;
    var quantity = document.getElementById("quantity" + pid).value;
    var action = "add";
  
    var oldcart = JSON.parse(localStorage.getItem(pid));
    if(oldcart != null)
    var oldquan = JSON.parse(localStorage.getItem(pid)).quantity;
    console.log("oldcart quan = " + oldquan);
  
    var data ={pid:pid, name:name, price:price, quantity:quantity};
    
    if(oldquan == 0 ||oldquan == null){
    localStorage.setItem(pid, JSON.stringify(data));
    }else{
    data ={pid:pid, name:name, price:price, quantity:++oldquan};
    localStorage.setItem(pid, JSON.stringify(data));
    }
  
    if(quantity > 0)
    {
  
      $.ajax({
        url:"action.php",
        method:"POST",
        async: false,
        data:{pid:pid, name:name, price:price, quantity:quantity, action:action},
        success:function(data)
        {
          load_cart_data();
          
        }
      });

    }
    else
    {
      alert("Error");
      window.location.replace("http://52.205.222.173/Public/index.php#");
    }
    valid();
  });
  
  $(document).on('click', '.btn-close', function(){
   
    var pid = $(this).attr("id");
    var oldcart = JSON.parse(localStorage.getItem(pid));
    if(oldcart != null)
    var oldquan = JSON.parse(localStorage.getItem(pid)).quantity;
    for(let j = oldquan; j>0; j--)
    minus(pid);


    console.log("item minussss");
    valid();
  });
  
  $(document).on('click', '#clear_cart', function(){
    var action = 'empty';
    $.ajax({
      url:"action.php",
      method:"POST",
      data:{action:action},
      success:function()
      {
        load_cart_data();
        $('#cart-popover').popover('hide');
        alert("Your Cart has been clear");
      }
    });
  
    localStorage.clear();
    $('#cart-popover').popover('hide');
    valid();
  });
  valid();
// });

function getFromServer() {
  return new Promise(resolve => {
    setTimeout(() => {
      resolve(JSON.stringify({
        purchase_units: [{
          amount: { currency_code: 'USD', value: 5, breakdown: { item_total: { currency_code: 'USD', value: 5 } } },
          // custom_id: "aabbccddeeff",  /* digest */
          // invoice_id: "001122334455", /* lastInsertId(); must be unique to avoid blocking */
          items: [ /* customized naming scheme: <Product ID:Product Name> */
            { name: "1:ProductA", unit_amount: { currency_code: 'USD', value: 1 }, quantity: 1 },
            { name: "2:ProductB", unit_amount: { currency_code: 'USD', value: 2 }, quantity: 2 }
          ]
        }]
      }));
    }, 100);
  });
}


$(document).ready(function(){
  function genInvoice() 
  {
      var cart = {};
      for(let i =0; i < localStorage.length; i++) {
          var pid = localStorage.key(i);
          var quantity = JSON.parse(localStorage.getItem(pid)).quantity;
          cart[pid] = quantity;
      }
      $.ajax({
          url:"digest.php",
          method:"POST",
          dataType:'json',
          data: {
              cart:cart
          },
          success:function(data)
          {    
            
              var addform = '<input type="hidden" name="custom" value="' + data.lastId + '"/><input type="hidden" name="invoice" value="'+ data.digest +'" />';
              $('#form1').append(addform);
              // clear handler
              $('#form1').off('submit');
              // actually submit the form
              $('#form1').submit();
          },
          error:(error) => {
              console.log(JSON.stringify(error));
              // alert("Out of Stocks!");
          }
      });
  }

  $('#form1').submit(function(e)
  {
    e.preventDefault();
    e.returnValue = false;
    var $form = $(this);
    $.ajax({
        type: 'post',
        url:"fetch_cart.php",
        dataType:"JSON",
        context: $form,
        success:function(data)
        {
          $('#form1').append(data.form);
          genInvoice();
        },
        error: (error) => {
          console.log(JSON.stringify(error));
        },
        complete: function(){
          $('#cart-popover').popover('hide');
          localStorage.clear();
        }
      });
  });
 
});