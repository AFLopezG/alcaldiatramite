<template>
    <q-page class="q-pa-xs">
        <div class="q-gutter-y-md" style="width: 100%">
      <q-tabs
        v-model="tab"
        dense
        class="bg-blue-7 text-white"
        full-width
      >
        <q-tab name="tramite" icon="dashboard_customize" label="Tramites" />
        <q-tab name="requisito" icon="group_work" label="Requisitos" />
        <q-tab name="proceso" icon="account_tree" label="Procesos" />
    </q-tabs>
        <q-tab-panels v-model="tab" animated>
          <q-tab-panel name="tramite">
            <div class="text-bold text-center text-h5">LISTADO DE TRAMITES</div>
          </q-tab-panel>
          <q-tab-panel name="requisito">
            <div class="text-bold text-center text-h5">LISTADO DE REQUISITOS</div>
            <q-table
                :rows="requisitos"
                :columns="colReq"
                row-key="name"
            />
          </q-tab-panel>
          <q-tab-panel name="proceso">
            <div class="text-bold text-center text-h5">LISTADO DE PROCESOS  </div>
          </q-tab-panel>
        </q-tab-panels>
      </div>
    </q-page>
</template>
<script>
export default {
    name:'tramitePage',
    data() {
        return {
            tab:'tramite',
            tramites:[],
            procesos:[],
            requisitos:[],
            tramite:{},
            proceso:{},
            requisito:{},
            perfiles:[],
            dialogTram:false,
            dialogProc:false,
            dialogReq:false,
            colTram:[
                {label:'',name:'',field:''},
            ],
            colReq:[
                {label:'OP',name:'op',field:'op'},
                {label:'DETALLE',name:'detalle',field:'detalle',align:'left'},
            ],
            colProc:[
                {label:'',name:'',field:''},
            ],

        }
    },
    created(){
        this.getTramites()
        this.getProcesos()
        this.getRequisitos()
        this.getPerfiles()
    },
    methods:{
        getRequisitos(){
            this.$api.get('requisito').then((res) => {
                console.log(res.data)
                this.requisitos=res.data
            })
        },
        getProcesos(){
            this.$api.get('proceso').then((res) => {
                this.procesos=res.data
            })
        },
        getTramites(){
            this.$api.get('tramite').then((res) => {
                this.tramites=res.data
            })
        },
        getPerfiles(){
            this.$api.get('profile').then((res) => {
                this.perfiles=res.data
            })
        }
    }
}
</script>