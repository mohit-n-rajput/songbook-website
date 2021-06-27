var currentPlaylist = [];  //save playlist , [] javascript array
var shufflePlaylist = [];   //save shuffle playlist , [] javascript array
var tempPlaylist = [];      //save current album playlist , [] javascript array
var audioElement;
var mouseDown = false;    //keep track mouse click or not
var currentIndex = 0;
var repeat = false;     // use for repeat song.
var shuffle = false;    // use for shuffle song.
var userLoggedIn;       //store name of login user.
var timer;   /*store timing of websites. also use for invalidate the search bar when we go on other page.*/

/* when we click  outside of the regioen of 3 dot image options dis-appear.*/
$(document).click(function(click) {
    var target = $(click.target);

    if(!target.hasClass("item") && !target.hasClass("optionsButton")) {
        hideOptionsMenu();
    }
});

/* window scroll event code ,3 dot options menu it disappear when scroll.*/
$(window).scroll(function() {
    hideOptionsMenu();
});

/* code for save playlist.*/
$(document).on("change", "select.playlist", function() {
    var select = $(this);
    var playlistId = select.val();
    var songId = select.prev(".songId").val();

    console.log("playlistId: " + playlistId);
    console.log("songId: " + songId)

    /*code for remove duplication*/
    $.post("include_files/form_handlers/ajax/removeDuplicateSongs.php", { playlistId: playlistId, songId: songId})
    .done(function(numRows) {

        /*check for duplication */
        if(numRows != 0) {
            alert("This song already exists in this playlist!");
            return;
        }

        $.post("include_files/form_handlers/ajax/addToPlaylist.php", { playlistId: playlistId, songId: songId})
        .done(function(error) {

            if(error != "") {
                alert(error);
                return;
            }

            hideOptionsMenu();
           /* use for show the default value on option box as add to playlist.,this refer callback*/
            select.val("");
        });
    });

});

/* update email function*/
function updateEmail(emailClass) {
    var emailValue = $("." + emailClass).val();

    $.post("include_files/form_handlers/ajax/updateEmail.php", { email: emailValue, username: userLoggedIn})
    .done(function(response) {
        $("." + emailClass).nextAll(".message").text(response);
    })


}


/* update password function*/
function updatePassword(oldPasswordClass, newPasswordClass1, newPasswordClass2) {
    /* use . for access the class.*/
    var oldPassword = $("." + oldPasswordClass).val();
    var newPassword1 = $("." + newPasswordClass1).val();
    var newPassword2 = $("." + newPasswordClass2).val();

    $.post("include_files/form_handlers/ajax/updatePassword.php",
        { oldPassword: oldPassword,
            newPassword1: newPassword1,
            newPassword2: newPassword2,
            username: userLoggedIn})

    .done(function(response) {
        $("." + oldPasswordClass).nextAll(".message").text(response);
    })


}

/* logout function*/
function logout() {
    $.post("include_files/form_handlers/ajax/logout.php", function() {
        location.reload();
    });
}

function openPage(url) {

    if(timer != null) {
        clearTimeout(timer);
    }

    //because if we pass more parameter in search box then we need ?
    if(url.indexOf("?") == -1) {
        url = url + "?";
    }
    /*encode uri is javascript in-built method convert appropriate url , if space is there ii removes it*/
    var encodedUrl = encodeURI(url + "&userLoggedIn=" + userLoggedIn);
    $("#mainContent").load(encodedUrl);
    // when page reload scroll to top
    $("body").scrollTop(0);

    /* it will remove previous history and show actual url,so user think that it change the url,actual page is shown in addrssBar or searchBar of browser.*/
    history.pushState(null, null, url); //main for dynamic moving of webpage.
}

/*remove song from current playlist*/

function removeFromPlaylist(button, playlistId) {
    var songId = $(button).prevAll(".songId").val();

    $.post("include_files/form_handlers/ajax/removeFromPlaylist.php", { playlistId: playlistId, songId: songId })
    .done(function(error) {

        if(error != "") {
            alert(error);
            return;
        }

        //do something when ajax returns
        openPage("playlist.php?id=" + playlistId);
    });
}





/* create function for create a playlist.*/
function createPlaylist() {

    console.log(userLoggedIn);
    var popup = prompt("Please enter the name of your playlist");

    if(popup != null) {

        /* done is work like success handler.*/
        $.post("include_files/form_handlers/ajax/createPlaylsit.php", { name: popup, username: userLoggedIn })
        .done(function(error) {

            if(error != "") {
                alert(error);
                return;
            }

            //do something when ajax returns
            openPage("yourMusic.php");
        });

    }

}

/* function for delete playlist*/
function deletePlaylist(playlistId) {
    var prompt = confirm("Are you sure you want to delte this playlist?");

    if(prompt == true) {

        console.log("playlist deleted")
        $.post("include_files/form_handlers/ajax/deletePlaylist.php", { playlistId: playlistId })
        .done(function(error) {

            if(error != "") {
                alert(error);
                return;
            }

            //do something when ajax returns
            openPage("yourMusic.php");
        });


    }
}

/* function for hiding the options when not needed.*/

function hideOptionsMenu() {
    var menu = $(".optionsMenu");
    if(menu.css("display") != "none") {
        menu.css("display", "none");
    }
}

/*  create the function for showing 3 dot menu.*/

function showOptionsMenu(button) {
    var songId = $(button).prevAll(".songId").val();
    var menu = $(".optionsMenu");
    var menuWidth = menu.width();
    menu.find(".songId").val(songId);

    var scrollTop = $(window).scrollTop(); //Distance from top of window to top of document
    var elementOffset = $(button).offset().top; //Distance from top of document

    var top = elementOffset - scrollTop;
    var left = $(button).position().left;

    menu.css({ "top": top + "px", "left": left - menuWidth + "px", "display": "inline" });

}

function formatTime(seconds){
    var time = Math.round(seconds);
    var minutes = Math.floor(time/60);
    var seconds = time - (minutes*60);

    /* for precisely show time we use extraZero if first digit after decimal is <10 */
    var extraZero = (seconds<10) ? "0" : ""; //Ternary operaotor

    return minutes + ":" + extraZero + seconds;
}

function updateTimeProgressBar(audio){
    //first update the starting time
    $(".progressTime.current").text(formatTime(audio.currentTime));

    //update the progress in progressBar
    var progress = (audio.currentTime/audio.duration) * 100;
    $(".playbackBar .progress").css("width", progress + "%");

    //last update the remaining time
    $(".progressTime.remaining").text("    " + " -" + formatTime(audio.duration - audio.currentTime));
}

function updateVolumeProgressBar(audio){
    var volume = audio.volume * 100;
    $(".volumeBar .progress").css("width", volume + "%");
}

/* responsible for access the artist page first song.*/
function playFirstSong() {
    setTrack(tempPlaylist[0], tempPlaylist, true);
}

/*
    create the audio class in javasript, class is like function in javascript
*/
//Audio class
function Audio() {
    this.currentlyPlaying; // for keep track of currently playing song
    this.audio = document.createElement('audio');
    /*create instant audio of html and pass it*/


    /* event listener for play nextSong() when song ended. */
    this.audio.addEventListener("ended", function() {
           nextSong();
    });

    /* add event Listeners, event listener for playSong()*/
    this.audio.addEventListener("canplay", function() {
        /*'this' refers to the object that the event was called on ,here this refers to audio object*/
        var songDuration = formatTime(this.duration)
        $(".progressTime.remaining").text(songDuration);
    });



    /* to update the remaining time */
    this.audio.addEventListener("timeupdate", function(){
            updateTimeProgressBar(this);  //here this is class Audio object
    });

    /* to change the volume */
    this.audio.addEventListener("volumechange", function(){
             /*here this is class Audio object ,we put this function in document.ready in nowplaying barcontainer.php so when document is ready then volume bar is fill up full, we can't put it in canplay() event because user can shows that volume is fill up when audio object is able to play song. */
            updateVolumeProgressBar(this);
    });


    /* instead of passing src of track we pass track which is json parameter contain all info.*/
    this.setTrack = function(track){
        this.currentlyPlaying = track;
        this.audio.src = track.path;
        /* IN bulit html element has some inbuilt feature like src*/
    }

    this.play = function() {
        this.audio.play();
    }

    this.pause = function() {
        this.audio.pause();
    }

    this.setTime = function(seconds) {
       this.audio.currentTime  =  seconds;
    }

}
