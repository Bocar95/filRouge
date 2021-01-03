import { NgModule, Component } from '@angular/core';
import { Routes, RouterModule } from '@angular/router';
import { AcceuilComponent } from './acceuil/acceuil.component';
import { AuthGuard } from './service/auth.guard';
import { ConnexionComponent } from './connexion/connexion.component';
import { ProfilComponent } from './acceuil/admin/profil/profil.component';
import { DetailsProfilComponent } from './acceuil/admin/profil/default-list-profils/details-profil/details-profil.component';

const routes: Routes = [
  { path: '', pathMatch: 'full', redirectTo: 'connexion'},
  { path: 'connexion', component: ConnexionComponent },
  { path: 'acceuil', component: AcceuilComponent, canActivate: [AuthGuard],
        children:[
          { path: ':id/details', component: DetailsProfilComponent },
          { path: ':id/modifier', component: AcceuilComponent },
          { path: ':id/delete', component: AcceuilComponent }
        ]
  },
  { path: 'acceuil/admin', component: AcceuilComponent, canActivate: [AuthGuard] },
  { path: 'acceuil/formateur', component: AcceuilComponent, canActivate: [AuthGuard] },
  { path: 'acceuil/cm', component: AcceuilComponent, canActivate: [AuthGuard] },
  { path: 'acceuil/apprenant', component: AcceuilComponent, canActivate: [AuthGuard] },
  { path: 'profil', component: ProfilComponent }
];

@NgModule({
  imports: [RouterModule.forRoot(routes)],
  exports: [RouterModule]
})
export class AppRoutingModule { }