        </section>
    </main>

    <footer>
        <img src="imagens/logotipo.png" alt="Logo <?php echo APP_NAME; ?>">
        <p>&copy; <?php echo date('Y'); ?> <?php echo APP_NAME; ?>. Todos os direitos reservados.</p>
        <p>Suporte: <?php echo SUPPORT_EMAIL; ?></p>
    </footer>

    <!-- Scripts -->
    <?php if ($paginaAtual === 'medico'): ?>
        <script src="js/medico.js"></script>
    <?php elseif ($paginaAtual === 'exame'): ?>
        <script src="js/exame.js"></script>
    <?php endif; ?>
</body>
</html> 