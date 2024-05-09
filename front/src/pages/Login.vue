<template>
    <q-layout view="lHh Lpr lFf" class="bg-grey-2">
      <div class="container cuerpologin" >

          <div class="row" aling="center">
            <div class="screen">
		<div class="screen__content">
			<q-form class="login" @submit.prevent="login">
				<div class="login__field">
					<i class="login__icon fas fa-user"></i>
					<input type="emial" class="login__input" placeholder="Correo" v-model="email" required>
				</div>
				<div class="login__field">
					<i class="login__icon fas fa-lock"></i>
					<input :type="typePassword?'password':'text'" class="login__input" placeholder="Password" v-model="password" required>
					<q-icon color="red-4" @click="typePassword=!typePassword" :name="typePassword?'visibility':'visibility_off'" />
				</div>
				<button class="button login__submit" type="submit">
					<span class="button__text">INGRESAR</span>
					<i class="button__icon fas fa-chevron-right"></i>
				</button>				
			</q-form>
			<div class="social-login">
				<h5><b>TRAMITES</b> <br>Gobierno Autonomo Municipal de Oruro</h5>

			</div>
		</div>
		<div class="screen__background">
			<span class="screen__background__shape screen__background__shape4"></span>
			<span class="screen__background__shape screen__background__shape3"></span>		
			<span class="screen__background__shape screen__background__shape2"></span>
			<span class="screen__background__shape screen__background__shape1"></span>
		</div>		
	</div>
            <div class="col-xs-1 col-sm-4"></div>
            <div class="col-xs-10 col-sm-4" hidden>
              <div class="text-subtitle1 text-center q-pt-xs text-grey">INGRESO AL SISTEMA TRAMITES</div>
              <div class="text-h6 text-center q-pa-xs text-black text-bold">GOBIERNO AUTONOMO MUNICIPAL DE ORURO<br>SECRETARIA MUNICIPAL DE GESTION TERRITORIAL  </div>
              <q-card flat bordered>
                <q-card-section >
                  <q-form class="q-pa-lg" @submit.prevent="login">
                    <div class="row">
                      <div class="col-12">
                        <q-input outlined v-model="email" label="Email" type="email" required />
                      </div>
                      <div class="col-12 q-pt-lg">
                        <q-input outlined v-model="password" label="Contraseña" :type="typePassword?'password':'text'" required >
                          <template v-slot:append>
                            <q-icon @click="typePassword=!typePassword" :name="typePassword?'visibility':'visibility_off'" />
                          </template>
                        </q-input>
                      </div>
                      <div class="col-12 q-pt-xs">
                        <q-btn size="22px" :loading="loading" class="full-width bold" color="primary" label="Iniciar Sesión" type="submit" no-caps />
                      </div>
                     </div>
                  </q-form>
                </q-card-section>
              </q-card>
              </div>
            <div class="col-1 col-sm-4"></div>
          </div>
      </div>
    </q-layout>
  </template>

  <script>
import {globalStore} from 'stores/globalStore'
  // import { Providers} from 'universal-social-auth'

  export default {
    name: 'LoginPage',
    data () {
      return {
        email: '',
        password: '',
        remember: false,
        typePassword: true,
        loading: false,
        store:globalStore()
      }
    },
    mounted () {
      if (this.store.isLoggedIn) {
        this.$router.push('/')
      }
    },
    methods: {
      login () {

        this.$q.loading.show()
        this.$api.post('login', {
          email: this.email,
          password: this.password
        }).then(res => {
          this.$q.notify({
            message: 'Bienvenido',
            color: 'positive',
            icon: 'check_circle',
            position: 'top'
          })
         // console.log(res.data)
		  //return false
          this.store.user = res.data.user
          this.store.units = ''
          this.store.cargo = res.data.user.cargo
          this.store.isLoggedIn = true
          res.data.user.units.forEach(r => {
			this.store.units+=r.nombre+' '
		  })
          res.data.user.permisos.forEach(r => {
            if (r.id === 1) this.store.booluser = true
            if (r.id === 2) this.store.boolregistro = true
            if (r.id === 3) this.store.boolasignacion = true
            if (r.id === 4) this.store.boolseg = true
            if (r.id === 5) this.store.booldelete = true
            if (r.id === 6) this.store.boolreporte = true
            if (r.id === 7) this.store.boolcambio = true
          })
          this.$api.defaults.headers.common.Authorization = 'Bearer ' + res.data.token
          localStorage.setItem('tokenTerri', res.data.token)
          this.$router.push('/')
        }).catch(error => {
          console.log(error)
          this.$q.notify({
            message: error.message,
            color: 'negative',
            position: 'top',
            timeout: 2000
          })
        }).finally(() => {
          this.$q.loading.hide()
        })
      }
    }
  }
  </script>
  <style >
  
  @import url('https://fonts.googleapis.com/css?family=Raleway:400,700');

.cuerpologin {
	box-sizing: border-box;
	margin: 0;
	padding: 0;	
	font-family: Raleway, sans-serif;
}


.container {
	display: flex;
	align-items: center;
	justify-content: center;
	min-height: 100vh;
}

.screen {		
	background: linear-gradient(90deg, #a45454, #b87878);		
	position: relative;	
	height: 600px;
	width: 360px;	
	box-shadow: 0px 0px 24px #965656;
}

.screen__content {
	z-index: 1;
	position: relative;	
	height: 100%;
}

.screen__background {		
	position: absolute;
	top: 0;
	left: 0;
	right: 0;
	bottom: 0;
	z-index: 0;
	-webkit-clip-path: inset(0 0 0 0);
	clip-path: inset(0 0 0 0);	
}

.screen__background__shape {
	transform: rotate(45deg);
	position: absolute;
}

.screen__background__shape1 {
	height: 520px;
	width: 520px;
	background: #FFF;	
	top: -50px;
	right: 120px;	
	border-radius: 0 72px 0 0;
}

.screen__background__shape2 {
	height: 220px;
	width: 220px;
	background: #ac6363;	
	top: -172px;
	right: 0;	
	border-radius: 32px;
}

.screen__background__shape3 {
	height: 540px;
	width: 190px;
	background: linear-gradient(270deg, #a45454, #9e6767);
	top: -24px;
	right: 0;	
	border-radius: 32px;
}

.screen__background__shape4 {
	height: 400px;
	width: 200px;
	background: #b97b7b;	
	top: 420px;
	right: 50px;	
	border-radius: 60px;
}

.login {
	width: 320px;
	padding: 30px;
	padding-top: 156px;
}

.login__field {
	padding: 20px 0px;	
	position: relative;	
}

.login__icon {
	position: absolute;
	top: 30px;
	color: #b57575;
}

.login__input {
	border: none;
	border-bottom: 2px solid #d4d1d1;
	background: none;
	padding: 10px;
	padding-left: 24px;
	font-weight: 700;
	width: 75%;
	transition: .2s;
}

.login__input:active,
.login__input:focus,
.login__input:hover {
	outline: none;
	border-bottom-color: #9e6767;
}

.login__submit {
	background: #fff;
	font-size: 14px;
	margin-top: 30px;
	padding: 16px 20px;
	border-radius: 26px;
	border: 1px solid #D4D3E8;
	text-transform: uppercase;
	font-weight: 700;
	display: flex;
	align-items: center;
	width: 100%;
	color: #9d4848;
	box-shadow: 0px 2px 2px #965656;
	cursor: pointer;
	transition: .2s;
}

.login__submit:active,
.login__submit:focus,
.login__submit:hover {
	border-color: #9e6767;
	outline: none;
}

.button__icon {
	font-size: 24px;
	margin-left: auto;
	color: #7875B5;
}

.social-login {	
	position: absolute;
	height: 160px;
	width: 250px;
	text-align: center;
	bottom: 0px;
	right: 0px;
	color: #fff;
}

.social-icons {
	display: flex;
	align-items: center;
	justify-content: center;
}

.social-login__icon {
	padding: 20px 10px;
	color: #fff;
	text-decoration: none;	
	text-shadow: 0px 0px 8px #7875B5;
}

.social-login__icon:hover {
	transform: scale(1.5);	
}


  </style>
