<template>
    <div class="q-pa-md">
      <q-btn
        label="Nuevo usuario"
        color="positive"
        @click="regDialog"
        icon="add_circle"
        class="q-mb-xs"
      />

      <q-dialog v-model="alert" full-width>
        <q-card >
          <q-card-section class="bg-green-14 text-white">
            <div class="text-h7"><q-icon name="add_circle" /> REGISTRO DE NUEVO USUARIO</div>
          </q-card-section>
          <q-card-section class="q-pt-xs">
            <q-form @submit="onSubmit" @reset="onReset" class="q-gutter-md">
              <div class="row">
                <div class="col-md-6 col-xs-12 q-pa-xs">
                <q-input outlined v-model="dato.cedula" type="text" label="Carnet " hint="Ingresar CI" dense lazy-rules :rules="[(val) => val.length > 5 || 'Por favor ingresa datos']" />
                <q-input outlined v-model="dato.name"   type="text" label="Nombre " hint="Ingresar Nombre" dense lazy-rules :rules="[(val) => val.length > 0 || 'Por favor ingresa datos']"/>
                <q-select dense hint="Cargo" v-model="cargo" :options="cargos" label="Cargo" outlined />
                <!--<q-select dense hint="Unidad" v-model="unit" :options="units" label="Unidad" outlined  @filter="filterFn" use-input v-if="store.unit.id==24"/>-->
                <q-input outlined dense v-model="dato.email" type="email" label="Email" hint="Correo electronico" lazy-rules :rules="[(val) => val.length > 0 || 'Por favor ingresa datos']" />
                <q-input outlined dense v-model="dato.password" label="Contraseña" hint="Contraseña" lazy-rules :rules="[(val) => val.length > 0 || 'Por favor ingresa datos']" :type="typePassword?'password':'text'">
                  <template v-slot:append>
                            <q-icon @click="typePassword=!typePassword" :name="typePassword?'visibility':'visibility_off'" />
                  </template>
                </q-input>
                <q-input outlined dense v-model="dato.fechalimite" type="date" label="Fecha Limite" lazy-rules :rules="[(val) => val.length > 0 || 'Por favor ingresa datos']" />

                </div>
                <div class="col-md-6 col-xs-12 q-pa-xs">
                  <div class="text-h6">PERMISOS</div>
                  <q-checkbox style="width: 100%"  v-for="(permiso,index) in permisos" :key="index" :label="permiso.nombre" v-model="permiso.estado" />
                </div>
              </div>

              <div>
                <q-btn label="Crear" type="submit" color="positive" icon="add_circle" />
                <q-btn label="Cancelar" icon="delete" color="negative" v-close-popup />
              </div>
            </q-form>
          </q-card-section>
        </q-card>
      </q-dialog>

      <q-table dense :filter="filter" title="REGISTRO DE USUARIOS" :rows="data" :columns="columns" row-key="name" :rows-per-page-options="[50,100]">
        <template v-slot:top-right>
          <q-input outlined dense debounce="300" v-model="filter" placeholder="Search">
            <template v-slot:append>
              <q-icon name="search" />
            </template>
          </q-input>
        </template>
        <template v-slot:body-cell-permisos="props">
            <q-td key="permisos" :props="props">
              <ul>
                <li v-for="(p,i) in props.row.permisos" :key="i">{{p.nombre}}</li>
              </ul>
            </q-td>
            </template>
            <template v-slot:body-cell-units="props">
            <q-td key="units" :props="props">
              <ul>
                <li v-for="(p,i) in props.row.units" :key="i">{{p.nombre}}</li>
              </ul>
            </q-td>
            </template>
            <template v-slot:body-cell-estado="props">
            <q-td key="estado" :props="props">
              <q-badge :color="props.row.state=='ACTIVO'?'green':'red'"  :label="props.row.state" @click="cambioEstado(props.row)" />
            </q-td>
            </template>
            <template v-slot:body-cell-opcion="props">

            <q-td key="opcion" :props="props">
              <q-btn dense round flat color="yellow" @click="editRow(props)" icon="edit" />
              <q-btn dense round flat color="positive" @click="cambiopass(props)" icon="vpn_key" />
              <q-btn dense round flat color="blue-10" @click="misunits(props)" icon="category" />
              <q-btn dense round flat color="green-10" @click="mispermisos(props)" icon="post_add" />
              <q-btn dense round flat color="orange-7" @click="misperfiles(props)" icon="group_add" />
              <q-btn dense round flat color="red" @click="deleteRow(props)" icon="delete"></q-btn>
            </q-td>

        </template>
      </q-table>

      <q-dialog v-model="dialog_mod">
        <q-card style="max-width: 80%; width: 50%">
          <q-card-section class="bg-warning text-white">
            <div class="text-h7"> <q-icon name="edit"/> MODIFICAR DATOS DE USUARIO</div>
          </q-card-section>
          <q-card-section class="q-pt-xs">
            <q-form @submit="onMod" class="q-gutter-md">
                <q-input
                outlined
                dense
              v-model="dato2.cedula"
              type="text"
              label="Carnet"
              hint="Ingresar CI"
              lazy-rules
              :rules="[(val) => val.length > 5 || 'Por favor ingresa datos']"
            />
              <q-input
              outlined
              dense
                v-model="dato2.name"
                type="text"
                label="Nombre "
                hint="Ingresar Nombre"
                lazy-rules
                :rules="[(val) => val.length > 0 || 'Por favor ingresa datos']"
              />

            <q-select dense v-model="cargo" :options="cargos" label="Cargo" outlined />
              <q-input
                filled
                dense
                v-model="dato2.email"
                type="email"
                label="Email"
                hint="Correo electronico"
                lazy-rules
                :rules="[(val) => val.length > 0 || 'Por favor ingresa datos']"
              />
              <q-input
              outlined
              dense
              v-model="dato2.fechalimite"
              type="date"
              label="Fecah Limite"
              lazy-rules
              :rules="[(val) => val.length > 0 || 'Por favor ingresa datos']"
            />
              <div>
                <q-btn label="Modificar" type="submit" color="positive" icon="add_circle" />
                <q-btn label="Cancelar" icon="delete" color="negative" v-close-popup />
              </div>
            </q-form>
          </q-card-section>
        </q-card>
      </q-dialog>

      <q-dialog v-model="dialog_del">
        <q-card>
          <q-card-section class="row items-center">
            <q-avatar icon="clear" color="red" text-color="white" />
            <span class="q-ml-sm">Seguro de eliminar Registro.</span>
          </q-card-section>

          <q-card-actions align="right">
            <q-btn flat label="Eliminar" color="deep-orange" @click="onDel" />
            <q-btn flat label="Cancelar" color="primary" v-close-popup />
          </q-card-actions>
        </q-card>
      </q-dialog>

      <q-dialog v-model="modelpermiso">
        <q-card style="width: 700px;max-width: 80vw">
          <q-card-section class="bg-info">
            <div class="text-h7 text-white"><q-icon name="folder"/> PERMISOS DE ACCESO</div>
          </q-card-section>
          <q-card-section>
            <q-form @submit.prevent="updatepermisos">
              <!--          v-on:click.native="updatepermiso(permiso)"-->
              <q-checkbox style="width: 100%"  v-for="(permiso,index) in permisos2" :key="index" :label="permiso.nombre" v-model="permiso.estado" />
              <!--          <q-form>-->
              <!--&lt;!&ndash;            <q-checkbox v-model="permisos" />&ndash;&gt;-->
              <!--          </q-form>-->
              <q-btn  type="submit" color="info" icon="send" label="Actualizar"></q-btn>
            </q-form>
          </q-card-section>
        </q-card>
      </q-dialog>

      <q-dialog v-model="dialogPerfil">
        <q-card style="width: 700px;max-width: 80vw">
          <q-card-section class="bg-info">
            <div class="text-h7 text-white"><q-icon name="folder"/> PERFILES DE USUARIO</div>
          </q-card-section>
          <q-card-section>
            <q-form @submit.prevent="updateperfil">
              <!--          v-on:click.native="updatepermiso(permiso)"-->
              <q-checkbox style="width: 100%"  v-for="(perfil,index) in perfiles" :key="index" :label="perfil.prof" v-model="perfil.estado" />
              <!--          <q-form>-->
              <!--&lt;!&ndash;            <q-checkbox v-model="permisos" />&ndash;&gt;-->
              <!--          </q-form>-->
              <q-btn  type="submit" color="info" icon="send" label="Actualizar"></q-btn>
            </q-form>
          </q-card-section>
        </q-card>
      </q-dialog>

      <q-dialog v-model="dialogUnit">
        <q-card style="width: 700px;max-width: 80vw">
          <q-card-section class="bg-info">
            <div class="text-h7 text-white"><q-icon name="folder"/> Unidades</div>
          </q-card-section>
          <q-card-section>
            <q-form @submit.prevent="updateUnit">
              <!--          v-on:click.native="updatepermiso(permiso)"-->
              <q-checkbox style="width: 100%"  v-for="(unidad,index) in unidades" :key="index" :label="unidad.nombre" v-model="unidad.estado" />
              <!--          <q-form>-->
              <!--&lt;!&ndash;            <q-checkbox v-model="permisos" />&ndash;&gt;-->
              <!--          </q-form>-->
              <q-btn  type="submit" color="info" icon="send" label="Actualizar"></q-btn>
            </q-form>
          </q-card-section>
        </q-card>
      </q-dialog>

    </div>
  </template>

  <script>
  import { date } from 'quasar'
  import moment from 'moment'
  import {globalStore} from   '../stores/globalStore'

  export default {
    name: 'UserPage',
    data () {
      return {
        store:globalStore(),
        dialogPerfil:false,
        alert: false,
        dialog_mod: false,
        dialog_del: false,
        typePassword: true,
        dialogUnit: false,
        fecha: date.formatDate(new Date(), 'YYYY-MM-DD'),
        filter: '',
        dato: { fechalimite: (moment(this.fecha).add(36, 'months').format('YYYY-MM-DD')) },
        model: '',
        dato2: {},
        options: [],
        props: [],
        unidad: [],
        unidades: [],
        permisos: [],
        permisos2: [],
        modelpermiso: false,
        cargos:[],
        unit:{},
        units:[],
        filterU:[],
        cargo:{},
        uni: {},
        perfiles:[],
        columns: [
          { name: 'cedula', align: 'left', label: 'CI ', field: 'cedula', sortable: true },
          { name: 'name', align: 'left', label: 'NOMBRE ', field: 'name', sortable: true },
          { name: 'cargo', align: 'left', label: 'CARGO ', field: row=>row.cargo.nombre, sortable: true },
          { name: 'units', align: 'left', label: 'UNIDADES ', field: 'units', sortable: true },
          { name: 'email', align: 'left', label: 'E-MAIL', field: 'email', sortable: true },
          { name: 'estado', align: 'left', label: 'ESTADO', field: 'state', sortable: true },
          { name: 'permisos', align: 'left', label: 'PERMISOS', field: 'permisos', sortable: true },
          { name: 'opcion', label: 'OPCIÓN', field: 'action', sortable: false }
        ],
        data: []
      }
    },

    mounted () {
      /* if (!this.$store.state.login.boolusuario){
         this.$router.replace({ path: '/' })
      } */

      this.misdatos()
      this.getCargo()
      this.getUnit()
      this.getProfile()
      if(this.store.units.length>0){
      this.unit=this.store.user.units[0]
      this.unit.label=this.unit.nombre}
      console.log(this.unit)
      this.$api.get('permiso').then(res => {
        res.data.forEach(r => {
          this.permisos.push({ id: r.id, nombre: r.nombre, estado: false })
          this.permisos2.push({ id: r.id, nombre: r.nombre, estado: false })
        })
      })
      this.$api.get('unit').then(res => {
        res.data.forEach(r => {
          this.unidades.push({ id: r.id, nombre: r.nombre, estado: false })
        })
      })

    },
    methods: {
      getProfile(){
        this.$q.loading.show()
        this.$api.get('profile').then(res => {
          this.perfiles=[]
          res.data.forEach(r => {
            r.estado=false
            this.perfiles.push(r)
          });
        this.$q.loading.hide()
      })
        },
     /* filterFn (val, update) {
        if (val === '') {
          update(() => {
            this.units = this.filterU

            // here you have access to "ref" which
            // is the Vue reference of the QSelect
          })
          return
        }

        update(() => {
          const needle = val.toLowerCase()
          this.units = this.filterU.filter(v => v.label.toLowerCase().indexOf(needle) > -1)
        })
      },*/
      cambioEstado(user1){
        this.$api.post('cambioEstado/' + user1.id).then(() => {
          this.misdatos()
        })

      },
      getCargo(){
        this.cargos=[]
        this.$api.get('cargo').then((res) => {
            res.data.forEach(r => {
            r.label=r.nombre
            this.cargos.push(r)
            })
        })
      },

      getUnit(){
        this.$api.get('unit').then((res) => {
          this.units=[]
            res.data.forEach(r => {
            r.label=r.nombre
            this.units.push(r)
            })
            this.filterU=this.units
        })
      },

      regDialog () {

        this.dato = { fechalimite: (moment(this.fecha).add(12, 'months').format('YYYY-MM-DD')) }
        this.cargo=this.cargos[1]
        this.alert = true
      },

      updatepermisos () {
        this.$api.put('updatepermisos/' + this.dato2.id, { permisos: this.permisos2 }).then(() => {
          // console.log(res.data)
          this.modelpermiso = false
          this.misdatos()
        }).catch(err => {
          this.$q.notify({
            message: err.response.data.message,
            icon: 'close',
            color: 'red'
          })
        })
      },
      updateperfil(){
        this.$api.put('updateperfil/' + this.dato2.id,  {perfiles:this.perfiles}).then(() => {
          // console.log(res.data)
          this.dialogPerfil = false
          this.misdatos()
        }).catch(err => {
          this.$q.notify({
            message: err.response.data.message,
            icon: 'close',
            color: 'red'
          })
        })
      },
      updateUnit () {
        this.$api.put('updateunits/' + this.dato2.id, { units: this.unidades }).then(() => {
          // console.log(res.data)
          this.dialogUnit = false
          this.misdatos()
        }).catch(err => {
          this.$q.notify({
            message: err.response.data.message,
            icon: 'close',
            color: 'red'
          })
        })
      },
      mispermisos (i) {
        // console.log(i.row)
        this.modelpermiso = true
        this.dato2 = i.row
        let p
        this.permisos2.forEach(pe => {
          // console.log(pe);
          p = this.dato2.permisos.find(r => r.pivot.permiso_id === pe.id)
          // console.log(p)
          if (p !== undefined) { pe.estado = true } else { pe.estado = false }
          // console.log(p)
        })
      },
      misperfiles (i) {
        // console.log(i.row)
        this.dialogPerfil = true
        this.dato2 = i.row
        let p
        this.perfiles.forEach(pe => {
          // console.log(pe);
          p = this.dato2.profiles.find(r => r.pivot.profile_id === pe.id)
          // console.log(p)
          if (p !== undefined) { pe.estado = true } else { pe.estado = false }
          // console.log(p)
        })
      },

      misunits (i) {
        // console.log(i.row)
        this.dialogUnit = true
        this.dato2 = i.row
        let p
        this.unidades.forEach(pe => {
          // console.log(pe);
          p = this.dato2.units.find(r => r.pivot.unit_id === pe.id)
          // console.log(p)
          if (p !== undefined) { pe.estado = true } else { pe.estado = false }
          // console.log(p)
        })
      },

      misdatos () {
        this.$q.loading.show()
        this.$api.post('listuser').then((res) => {
          console.log(res.data)
          this.data = res.data
          this.$q.loading.hide()
        })
      },
      editRow (item) {
        this.dato2 = item.row
        this.cargo = item.row.cargo
        this.cargo.label = this.cargo.nombre
        // console.log(this.dato2)
        this.dialog_mod = true
      },
      deleteRow (item) {
        this.dato2 = item.row
        this.dialog_del = true
      },
      onSubmit () {
        this.$q.loading.show()
        this.$api.post('user', {
          cedula: this.dato.cedula,
          name: this.dato.name,
          password: this.dato.password,
          email: this.dato.email,
          fechalimite: this.dato.fechalimite,
          cargo_id:this.cargo.id,
          cargo:this.cargo.nombre,
          permisos: this.permisos
        }).then(() => {
          // console.log(res.data)
          this.$q.notify({
            color: 'green-4',
            textColor: 'white',
            icon: 'cloud_done',
            message: 'Creado correctamente'
          })
          this.dato = { fechalimite: (moment(this.fecha).add(12, 'months').format('YYYY-MM-DD')) }
          this.alert = false
          this.misdatos()
        }).catch(err => {
          console.log(err.response.data)
          this.$q.notify({
            message: err.response.data.message,
            icon: 'close',
            color: 'red'
          })
          this.$q.loading.hide()
        })
      },
      onMod () {
        this.$q.loading.show()
        this.$api.put('user/' + this.dato2.id, {
          cedula: this.dato2.cedula,
          name: this.dato2.name,
          cargo_id: this.cargo.id,
          cargo: this.cargo.nombre,
          email: this.dato2.email,
          fechalimite: this.dato2.fechalimite
        }).then(() => {
          this.$q.notify({
            color: 'green-4',
            textColor: 'white',
            icon: 'cloud_done',
            message: 'Modificado correctamente'
          })
          this.dialog_mod = false
          this.misdatos()
        })
      },
      onDel () {
        this.$q.loading.show()
        this.$api.delete('user/' + this.dato2.id)
          .then(() => {
            this.$q.notify({
              color: 'green-4',
              textColor: 'white',
              icon: 'cloud_done',
              message: 'Eliminado correctamente'
            })
            this.dialog_del = false
            this.misdatos()
          }).catch(err => {
            this.$q.loading.hide()
            this.$q.notify({
              message: err.response.data.message,
              icon: 'error',
              color: 'red'
            })
          })
      },
      onReset () {
        this.dato.nombre = null
        this.dato.inicio = 0
        this.dato.fin = 0
      },
      cambiopass (i) {
        // console.log(i.row);
        this.$q.dialog({
          title: 'CAMBIAR PASSWORD',
          message: 'Ingresar nueva contraseña',
          prompt: {
            model: '',
            type: 'text' // optional
          },
          cancel: true,
          persistent: true
        }).onOk(data => {
          this.$q.loading.show()
          this.$api.put('updatePassword/' + i.row.id, { password: data }).then(() => {
            this.$q.loading.hide()
          })
        }).onCancel().onDismiss()
      }
    }
  }
  </script>
