<link rel="stylesheet" href="../CSS/footer.css">
<link rel="stylesheet" href="../CSS/add-avis.css"
<footer>
<button class="add_buttons" id="open-avis-btn">Poster un Avis</button>
    <div class="footer">
        <p>Ouvert du lundi au dimanche de 9H a 18H  sans interruption</p>
        <p>contact@arcadia.com</p>
        <p>© 2024 Le Zoo D'Arcadia, Website non promotionnel</p>
        <p>Site réalisé dans le cadre d'un ECF à destination de STUDI</p>
        <p>Diverses sources proviennent d'un générateur IA et de différents sites.</p>
    </footer>
    <script>        
        document.getElementById('open-avis-btn').addEventListener('click', function() {
        window.open('../HTML/avis.htm', 'Poster un Avis', 'width=400,height=600');
    });
    </script>