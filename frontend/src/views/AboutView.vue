<template>
  <div class="about">

    <div class="message">
      <h2>How does it work?</h2>
      <p>
        When the request is executed, the data is sent to the server through the API
        to create an asynchronous task, the API returns an identifier and the application waits for the task to execute.
        Once the data hits the server, a private database is created on the fly. All queries are executed as part of a
        transaction, which is rolled back.
        For each query and scheme a unique URL is created, if the query or scheme is changed a
        a new URL will be created. This allows you to use the browser's "backward", "forward" and "reload" functions to
        the fullest extent.
      </p>
    </div>
    <div style="margin-bottom: 2em" class="message">

      <h2>What platform is it running on?</h2>
      <p>This application uses a variety of technologies that work together to accomplish the tasks at hand.</p>
      <table class="table table-no-more">
        <thead>
        <tr>
          <th>Title</th>
          <th>Description</th>
        </tr>
        </thead>
        <tbody>
        <tr>
          <td>
            <a rel="nofollow" href="https://www.docker.com/">Docker</a>
          </td>
          <td>
            VM management
          </td>
        </tr>
        <tr>
          <td>
            <a rel="nofollow" href="https://symfony.com/">Symfony 6</a>
          </td>
          <td>
            For a backend application with Messenger+Doctrine component to perform async tasks
          </td>
        </tr>
        <tr>
          <td>
            <a rel="nofollow" href="https://symfony.com/doc/current/mercure.html">Mercure Protocol</a>
          </td>
          <td>
            For life pushing data
          </td>
        </tr>
        <tr>
          <td>
            <a rel="nofollow" href="https://api-platform.com/">Api platform</a>
          </td>
          <td>
            For creation REST API
          </td>
        </tr>
        <tr>
          <td>
            <a rel="nofollow" href="http://www.postgresql.org">PostgreSQL</a>
          </td>
          <td>
            This base is used as the central date base for the application
          </td>
        </tr>
        <tr>
          <td>
            <a rel="nofollow" href="https://vuejs.org/">Vue 3</a>
          </td>
          <td>
            For frontend application
          </td>
        </tr>
        <tr>
          <td>
            <a rel="nofollow" href="http://www.codemirror.net">CodeMirror</a>
          </td>
          <td>
            For browser-based SQL editing with text highlighting.
          </td>
        </tr>

        <tr>
          <td>
            <a rel="nofollow" href="https://www.flaticon.com/">Flaticon</a>
          </td>
          <td>
            All icons created by zafdesign
          </td>
        </tr>


        </tbody>
      </table>
    </div>


    <div class="message">
      <h2>Privacy</h2>
      <p>
        The application does not use metrics and does not save any data other than sql queries. IP address, UserAgent,
        Cookies and other data are ignored and not stored. SQL queries are not indexed, so if you don't post a link,
        they are not visible to anyone else.
      </p>
    </div>
    <div class="message">
      <h2>License</h2>
      <p>
        By using sqldaddy.io, you agree to license everything you submit by <a
          href="https://creativecommons.org/publicdomain/zero/1.0/legalcode"><b>Creative Commons CC0</b></a> <br>
        <b>Project license:  GNU GPL Version 3</b>
      </p>
    </div>
    <div class="message" id="contribute">
      <h2>Contributing</h2>
      <p>
        Sqldaddy.io is an open source project published on <a href="https://github.com/sqldaddy-io/sqldaddy"><b>GitHub</b></a>.
        You can support the project with a contribution or donation. See the <a href="https://github.com/sqldaddy-io/sqldaddy"><b>repository</b></a> page for more information on contribution rules.<br> <b>Project license:  GNU GPL Version 3</b>
      </p>

    </div>

    <div class="message bright_bс" id="donate">
      <h2>Support the project</h2>
      <p>
        This application is completely free (like air) and is maintained at the expense of the author. If you want to
        support the project, you can buy the author a coffee. Donations will be used to pay for infrastructure and
        development of the service.
      </p>
      <div class="image_buttons">
        <a href="https://www.patreon.com/emrdev"><img height="75" src="@/assets/img/become-a-patron-button.png" alt=""></a>
        <a href="https://www.buymeacoffee.com/emr_dev"><img src="https://img.buymeacoffee.com/button-api/?text=Buy me a coffee&emoji=&slug=emr_dev&button_colour=FFDD00&font_colour=000000&font_family=Cookie&outline_colour=000000&coffee_colour=ffffff"/></a>
      </div>
    </div>

  </div>
</template>

<style scoped>
h1, h2, h3 {
  line-height: 40px;
}

p {
  line-height: 30px;
}

hr {
  margin-top: 30px;
  margin-bottom: 30px;
}


.message h2 {
  margin-bottom: 0.5em;
}

.message p {
  margin-bottom: 1em;
}

table th a {
  color: white;
}

.image_buttons{
  display: flex;
  justify-content: start;
  align-items: center;
}
@media (max-width: 800px) {
  .image_buttons{
    width: 100%;
    flex-direction: column;
    align-items: unset;
  }
  .message{
    padding: 15px 15px;
  }
}

.bright_bс{
  background: #00000012;
  border-radius: 15px;
  padding: 15px;
}
.dark .bright_bс{
  background: #f7f7f712;
}

</style>
