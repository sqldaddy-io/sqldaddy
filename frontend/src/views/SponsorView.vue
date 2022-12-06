<template>
  <div class="sponsors">
    <div class="message bright_bс" id="donate">
      <h2>Become a sponsor</h2>
      <p>
        This app is completely free (like air) and is maintained at the author's expense. If you want to
        support the project, you can buy the author a coffee or become a regular subscriber. Your support will help the service continue to be available and add new features.
      </p>
      <hr>
        <p>I will add your name and Twitter handle / GitHub profile to the list of sponsors for a year (don't forget to <a href="mailto:emrdev@outlook.com">email</a> me the details).</p>
      <div class="image_buttons">
        <a href="https://www.buymeacoffee.com/emr_dev"><img src="https://img.buymeacoffee.com/button-api/?text=Become a sponsor/ Donate&emoji=&slug=emr_dev&button_colour=FFDD00&font_colour=000000&font_family=Cookie&outline_colour=000000&coffee_colour=ffffff"/></a>
      </div>
      <h2 style="margin-top: 25px">Sponsors</h2>
      <table class="table table-no-more" style="margin-top: 15px">
        <thead>
        <tr>
          <th>Date</th>
          <th>Link</th>
        </tr>
        </thead>
        <tbody>
        <tr>
          <td>
            06.12.22
          </td>
          <td>
            <a href="https://twitter.com/emrdevx" target="_blank" rel="noopener">emrdev</a>
          </td>
        </tr>
        </tbody>
      </table>

    </div>
  </div>
</template>
<script>

import {mapActions} from "vuex";
export default {
  'name': 'SponsorView',
  created() {
    this.setMetaTitle('Become a sponsor');
    this.setMetaDescription('Support the project if you like it. This will allow the project to continue to be available and develop');
  },
  methods: {
    ...mapActions({
      'setMetaTitle': 'setMetaTitle',
      'setMetaDescription': 'setMetaDescription',
    }),
  },
}
</script>
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

a{
  font-weight: 900;
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
