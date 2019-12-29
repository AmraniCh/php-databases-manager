// STRAIGHT LOADER
function StraightLoader(action){
  if( action === "hide" ){
      $(".loader-straight").hide()
        $(".section-container").css({
          opacity: "1",
          "user-select": "initial"
        })
  }
  if( action === "show" ){
     $(".loader-straight").show()
     $(".section-container").css({
       opacity: ".2",
       "user-select": "none"
     })
   }
}

// ROUNDED LOADER
function RoundedLoader(action, text){
  if( action === "show" ){
    $(".loader-rounded").show()
    $(".loader-rounded .loader-text").text(text)
  }
  if(action === "hide")
    $(".loader-rounded").hide()
}

// SIDEBAR LOADER
function SidebarLoader(action){
  if( action == "show" ){
    $(".loader-sidebar").show()
  }
  if( action == "hide" ){
    $(".loader-sidebar").hide()
  }
}
