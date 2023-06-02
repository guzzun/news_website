// sidemenu
function openMenu() {   
    document.getElementById("mySideMenu").style.width = "250px";
    var element = document.getElementById("content");
    element.classList.add("content_mask");
    var element = document.getElementById("header");
    element.classList.add("content_mask");
  }
  
  function closeMenu() {
    document.getElementById("mySideMenu").style.width = "0";
    var element = document.getElementById("content");
    element.classList.remove("content_mask");
    var element = document.getElementById("header");
    element.classList.remove("content_mask");
  }
  
//   switch_mode
function switchMode() {
    var element = document.body;
   element.classList.toggle("dark_mode");
  }


// sort post_block
post_blocks = document.getElementsByClassName("post_block");

function sort_post_blocks_display_all(){
  for (let i = 0; i < post_blocks.length; i++)
    post_blocks[i].style.display = "block";
}

function sort_post_blocks(category){
  for (let i = 0; i < post_blocks.length; i++) {
    blockType = post_blocks[i].getAttribute("blockType");
    if(blockType == category)
      post_blocks[i].style.display = "block";
    else
      post_blocks[i].style.display = "none";
  }
}
