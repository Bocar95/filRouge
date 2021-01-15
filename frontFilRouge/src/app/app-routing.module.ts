import { NgModule } from '@angular/core';
import { Routes, RouterModule } from '@angular/router';
import { AcceuilComponent } from './acceuil/acceuil.component';
import { AuthGuard } from './service/authGuardService/auth.guard';
import { ConnexionComponent } from './connexion/connexion.component';
import { ProfilComponent } from './acceuil/admin/profil/profil.component';
import { DetailsProfilComponent } from './acceuil/admin/profil/details-profil/details-profil.component';
import { AdminUserComponent } from './acceuil/admin/admin-user/admin-user.component';
import { FormulaireAddAdminComponent } from './acceuil/admin/formulaire-add-admin/formulaire-add-admin.component';
import { FormulairePutAdminComponent } from './acceuil/admin/formulaire-put-admin/formulaire-put-admin.component';


const routes: Routes = [
  { path: '', pathMatch: 'full', redirectTo: 'connexion'},
  { path: 'connexion', component: ConnexionComponent },
  { path: 'acceuil', component: AcceuilComponent, canActivate: [AuthGuard],
        children:[
              { path: 'liste/profils', component: ProfilComponent,
                    children:[
                      { path: ':id/details', component: DetailsProfilComponent },
                      { path: ':id/modifier', component: ProfilComponent },
                      { path: ':id/delete', component: ProfilComponent }
                    ]
              },
              { path: 'liste/admins', component: AdminUserComponent,
                    children:[
                      { path: ':id/delete', component: AdminUserComponent },
                      { path: ':id/modifier', component: FormulairePutAdminComponent }
                    ]
              },
              { path: 'ajouter/admin', component: FormulaireAddAdminComponent }
        ]
  }
];

@NgModule({
  imports: [RouterModule.forRoot(routes)],
  exports: [RouterModule]
})
export class AppRoutingModule { }