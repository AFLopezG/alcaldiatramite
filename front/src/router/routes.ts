import { RouteRecordRaw } from 'vue-router'
import MainLayout from 'layouts/MainLayout.vue'
import IndexPage from 'pages/IndexPage.vue'
import Login from 'pages/Login.vue'
import Usuarios from 'pages/Usuarios.vue'
import Asignacion from 'pages/Asignacion.vue'
import Seguimiento from 'pages/Seguimiento.vue'
import Reporte from 'pages/Reporte.vue'
import Consulta from 'pages/Consulta.vue'
import Perfiles from 'pages/Perfiles.vue'
import Unidades from 'pages/Unidades.vue'
import Tramites from 'pages/Tramites.vue'
import Vertramite from 'pages/VerTramite.vue'
import Listado from 'pages/Listado.vue'

const routes: RouteRecordRaw[] = [
  {
    path: '/',
    component: MainLayout,
    children: [
      { path: '', component: IndexPage, meta: { requiresAuth: true } },
      { path: '/perfiles', component: Perfiles, meta: { requiresAuth: true } },
      { path: '/unidades', component: Unidades, meta: { requiresAuth: true } },
      { path: '/usuarios', component: Usuarios, meta: { requiresAuth: true } },
      { path: '/tramites', component: Tramites, meta: { requiresAuth: true } },
      { path: '/asignacion/:tipoasignacion', component: Asignacion, meta: { requiresAuth: true } },
      { path: '/seguimiento', component: Seguimiento, meta: { requiresAuth: true } },
      { path: '/reporte', component: Reporte, meta: { requiresAuth: true } },
      { path: '/vertramite/:id/:tr', component: Vertramite, meta: { requiresAuth: true } },
      { path: '/listado', component: Listado, meta: { requiresAuth: true } },
    ],
  },
  {
    path: '/login',
    component: Login
  },
  {
    path: '/consulta/:codigo*',
    component: Consulta,
  },
  // Always leave this as last one,
  // but you can also remove it
  {
    path: '/:catchAll(.*)*',
    component: () => import('pages/ErrorNotFound.vue'),
  },
];

export default routes;
