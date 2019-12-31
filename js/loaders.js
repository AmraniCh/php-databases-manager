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
    $(".login-container").css({
      "user-select": "none",
      "opacity": ".4"
    })
    $(".login-container input, .login-container select").css("pointer-events", "none")
    $(".loader-rounded").show()
    $(".loader-rounded .loader-text").text(text)
  }
  if(action === "hide"){
    $(".loader-rounded").hide()
    $(".login-container").css({
      "user-select": "initial",
      "opacity": "1"
    })
    $(".login-container input, .login-container select").css("pointer-events", "initial")
  }
}

// SIDEBAR LOADER
function SidebarLoader(action){
  if( action == "show" ) $(".loader-sidebar").show()
  if( action == "hide" ) $(".loader-sidebar").hide()
}
