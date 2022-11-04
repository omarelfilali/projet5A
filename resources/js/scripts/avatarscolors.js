

// COLOR AVATAR - Pour les bulles initiales 
// Plus d'infos sur : https://marcoslooten.com/blog/creating-avatars-with-colors-using-the-modulus/

const colors = ['#90a955', '#B5E48C', '#99D98C', '#76C893', '#52B69A', '#34A0A4', '#168AAD', '#1A759F', '#1E6091', '#184E77'];

const colorsEtudiants = ['#F94144', '#F3722C', '#F8961E', '#F9844A', '#F9C74F', '#780000', '#EE9B00', '#AE2012', '#BB3E03', '#9B2226'];


function numberFromText(text) {
    // numberFromText("AA");
    const charCodes = text
        .split('') // => ["A", "A"]
        .map(char => char.charCodeAt(0)) // => [65, 65]
        .join(''); // => "6565"
    return parseInt(charCodes, 10);
}

const avatars = document.querySelectorAll('.initiales');

avatars.forEach(avatar => {
    const text = avatar.innerText; // => "AA"
    avatar.style.backgroundColor = colors[numberFromText(text) % colors.length]; // => "#DC2A2A"
});

const avatarsEtudiants = document.querySelectorAll('.initiales-etudiants');

avatarsEtudiants.forEach(avatarsEtudiants => {
    const text = avatarsEtudiants.innerText; // => "AA"
    avatarsEtudiants.style.backgroundColor = colorsEtudiants[numberFromText(text) % colorsEtudiants.length]; // => "#DC2A2A"
});