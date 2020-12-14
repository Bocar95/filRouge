import { NgModule, Component } from '@angular/core';
import { Routes, RouterModule } from '@angular/router';
import { AcceuilComponent } from './acceuil/acceuil.component';
import { ConnexionComponent } from './connexion/connexion.component';

const routes: Routes = [
  { path: '', pathMatch: 'full', redirectTo: 'connexion'},
  { path: 'connexion', component: ConnexionComponent },
  { path: 'acceuil/admin', component: AcceuilComponent },
  { path: 'acceuil/formateur', component: AcceuilComponent },
  { path: 'acceuil/cm', component: AcceuilComponent },
  { path: 'acceuil/apprenant', component: AcceuilComponent }
];

@NgModule({
  imports: [RouterModule.forRoot(routes)],
  exports: [RouterModule]
})
export class AppRoutingModule { }