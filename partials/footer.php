</main>

<footer class="footer">
  <small>© <?= date('Y') ?> MI Ma'arif Aditirto Kebumen. All rights reserved.</small>
</footer>

<style>
  .footer {
    background: #222;
    color: #fff;
    text-align: center;
    padding: 15px 10px;
    margin-top: 40px;
    width: 100%;
  }

  /* biar footer tetap di bawah */
  html, body {
    height: 100%;
  }
  body {
    display: flex;
    flex-direction: column;
  }
  main {
    flex: 1;
  }
</style>

</body>
</html>
