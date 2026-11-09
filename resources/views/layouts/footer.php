    </main>

    <footer class="site-footer">
        <span>© 2026 Universitas Cakrawala Nusantara</span>
        <span>Sistem Informasi Akademik · Universitas Cakrawala Nusantara</span>
        <nav><a href="#">Panduan <?= !empty($isDosen) ? 'dosen' : 'mahasiswa' ?></a><a href="mailto:akademik@ucn.ac.id">Hubungi akademik</a></nav>
    </footer>
    <script src="<?= e(url('js/portal.js')) ?>"></script>
</body>
</html>
