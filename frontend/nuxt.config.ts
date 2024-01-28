import vuetify, { transformAssetUrls } from 'vite-plugin-vuetify'
export default defineNuxtConfig({
  ssr: false,
  build: {
    transpile: ['vuetify'],
  },
  modules: [
    (_options, nuxt) => {
      nuxt.hooks.hook('vite:extendConfig', (config) => {
        // @ts-expect-error
        config.plugins.push(vuetify({ autoImport: true }))
      })
    },
    '@pinia/nuxt',
    '@nuxtjs/apollo'
    //...
  ],
  pinia: {
    storesDirs: ['./stores/**', './custom-folder/stores/**'],
  },
  vite: {
    vue: {
      template: {
        transformAssetUrls,
      },
    },
  },
  apollo: {
    clients: {
      default: {
        httpEndpoint: ''+process.env.GRAPHQL_URL + '',
        tokenStorage: 'cookie',
        httpLinkOptions: {
          fetchOptions: {
            mode: 'cors' //Cors Needed for external Cross origins, need to allow headers from server
          },
          credentials: 'omit'
        },
        inMemoryCacheOptions: {
          addTypename: false
        }
      }
    }
  }
})
