<template>
  <div class="modal open" v-if="show" @click.stop="hideDialog">
    <div class="modal-content">
      <div @click.stop class="modal-box">
        <span class="close" @click.stop="hideDialog">&times;</span>
        <p class="header">Share</p>
        <div class="social-icons">
          <a @click="shareEmbedShow()" href="javascript:void(0)" >
            <img :src="this.getSocialUrlSvg('Embed')" >
            <p>Embed</p>
          </a>
          <ShareNetwork v-for="(network, index) in this.networks"
                        v-bind:key="index"
                        :network="network.network"
                        :url="this.urlPage"
                        title=""
          >
            <img :src="getSocialUrlSvg(network.network)"/>
            <p v-text="network.text"></p>
          </ShareNetwork>
        </div>

        <div class="shareInput">
          <input type="text" disabled :value="this.urlPage">
          <button @click="copyToClipboard()">copy</button>
        </div>


      </div>
    </div>
  </div>

  <TheEmbedDialog  v-model:show="shareEmbed"/>

</template>
<script>
import {mapGetters} from 'vuex'
import toggleMixin from "@/mixins/toggleMixin";
import config from "@/config";
import TheEmbedDialog from "@/components/ui/TheEmbedDialog.vue";

export default {
  name: 'TheShareDialog',
  components: {TheEmbedDialog},
  data() {
    return {
      shareEmbed: false,
      shareOptions: {
        url: this,
        title: '',
        text: '',
      },
      networks: [
        {
          'network': 'Email',
          'text': 'Email',
        },
        {
          'network': 'LinkedIn',
          'text': 'LinkedIn',
        },
        {
          'network': 'Twitter',
          'text': 'Twitter',
        },
        {
          'network': 'Reddit',
          'text': 'Reddit',
        },
        {
          'network': 'Facebook',
          'text': 'Facebook',
        },
        {
          'network': 'WhatsApp',
          'text': 'WhatsApp',
        },
        {
          'network': 'Telegram',
          'text': 'Telegram',
        },
        {
          'network': 'Viber',
          'text': 'Viber',
        },
        {
          'network': 'VK',
          'text': 'VK',
        },
        {
          'network': 'Messenger',
          'text': 'Messenger',
        },
        {
          'network': 'Skype',
          'text': 'Skype',
        }
      ]
    }
  },
  mixins: [toggleMixin],
  computed: {
    ...mapGetters({}),
    urlPage: {
      get() { return config.hostname + '/' + this.$route.params?.path }
    },
  },

  methods: {
    shareEmbedShow() {
     this.shareEmbed = true;
      this.hideDialog()
    },
    getSocialUrlSvg(name) {
      return require('../../assets/img/social/' + name + '.svg')
    },
    copyToClipboard() {
      const copyText = this.shareOptions.url;
      const textArea = document.createElement('textarea')
      textArea.textContent = copyText
      document.body.append(textArea)
      textArea.select()
      document.execCommand('copy');
      textArea.remove();
    }
  }
}
</script>

<style scoped>


.social-icons {
  display: flex;
  justify-content: center;
  flex-wrap: wrap;
  gap: 30px;
}

.social-icons a {
  text-align: center;
  width: 60px;
}

.social-icons img {
  width: 100%;
}

.social-icons a p {
  font-size: 16px;
  margin-top: 5px;
}

.header {
  font-size: 25px;
  margin-bottom: 15px;
}


.shareInput {
  display: flex;
  justify-content: center;
  margin-top: 25px;
  position: relative;
}

.shareInput input {
  padding: 15px;
  border-radius: 5px;
  background: transparent;
  border: 1px solid #e5e3e3;
  font-size: 16px;
  width: 100%;
}

.shareInput button {
  position: absolute;
  right: 8px;
  top: 10px;
  border: 1px solid #e5e3e3;
  padding-top: 5px;
  padding-bottom: 5px;
  padding-left: 15px;
  padding-right: 15px;
  border-radius: 15px;
  font-size: 16px;
}

.shareInput button:active {
  background: #e5e3e3;
}


.dark .shareInput input {
  border: 1px solid #6b6b6b;
  color: #d0d0d0;
}

.dark .shareInput button {
  border: 1px solid #6b6b6b;
  background: #313131;
  color: white;
}

.dark .shareInput button:active {
  background: #484848;
}
</style>
