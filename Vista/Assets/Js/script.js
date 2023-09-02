// SIDEBAR DROPDOWN
const allDropdown = document.querySelectorAll('#sidebar .side-dropdown');
const sidebar = document.getElementById('sidebar');
const content = document.getElementById('content');
allDropdown.forEach(item => {
    const a = item.parentElement.querySelector('a:first-child');
    a.addEventListener('click', function (e) {
        e.preventDefault();
        if (!this.classList.contains('active')) {
            allDropdown.forEach(i => {
                const aLink = i.parentElement.querySelector('a:first-child');

                aLink.classList.remove('active');
                i.classList.remove('show');
            })
        }
        this.classList.toggle('active');
        item.classList.toggle('show');
    })
})

// SIDEBAR COLLAPSE
const toggleSidebar = document.querySelector('nav .toggle-sidebar');
const allSideDivider = document.querySelectorAll('#sidebar .divider');

if (sidebar.classList.contains('hide')) {
    allSideDivider.forEach(item => {
        item.textContent = '♡';
    })
} else {
    allSideDivider.forEach(item => {
        item.textContent = item.dataset.text;
    })
}

toggleSidebar.addEventListener('click', function () {
    sidebar.classList.toggle('hide');
    content.classList.toggle('hide')

    if (sidebar.classList.contains('hide')) {
        allSideDivider.forEach(item => {
            item.textContent = '___';
        })
    } else {
        allSideDivider.forEach(item => {
            item.textContent = item.dataset.text;
        })
    }
})


// sidebar.addEventListener('mouseleave', function () {
//     if (this.classList.contains('hide')) {
//         allDropdown.forEach(item => {
//             const a = item.parentElement.querySelector('a:first-child');
//             a.classList.remove('active');
//             item.classList.remove('show');
//         })
//         allSideDivider.forEach(item => {
//             item.textContent = '♡';
//         })
//     }
// })
// sidebar.addEventListener('mouseenter', function () {
//     if (this.classList.contains('hide')) {
//         allDropdown.forEach(item => {
//             const a = item.parentElement.querySelector('a:first-child');
//             a.classList.remove('active');
//             item.classList.remove('show');
//         })
//         allSideDivider.forEach(item => {
//             item.textContent = item.dataset.text;
//         })
//     }
// })



// PROFILE DROPDOWN
const profile = document.querySelector('nav .profile');
const imgProfile = document.querySelector('.img');
const dropdownProfile = document.querySelector('.profile-link');

imgProfile.addEventListener('click', function () {
    dropdownProfile.classList.toggle('show');
})

window.addEventListener('click', function (e) {
    if (e.target !== imgProfile) {
        if (e.target !== dropdownProfile) {
            if (dropdownProfile.classList.contains("show")) dropdownProfile.classList.remove("show");
        }
    }
})

// PROGRESSBAR
const allProgress = document.querySelectorAll('main .card .progress');

allProgress.forEach(item => {
    item.style.setProperty('--value', item.dataset.value)
})

// DARKMODE
const mode = document.getElementById('mode');

if(this.checked){
    document.body.classList.add('dark');
}else{
    document.body.classList.remove('dark');
}

mode.addEventListener('change',function(){
    if(this.checked){
        document.body.classList.add('dark');
    }else{
        document.body.classList.remove('dark');
    }
})
