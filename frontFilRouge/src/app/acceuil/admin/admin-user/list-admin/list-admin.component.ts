import { Component, OnInit } from '@angular/core';
import { Router, RouterStateSnapshot } from '@angular/router';
import { ConfirmationService } from 'primeng/api';
import { AdminUserService } from 'src/app/service/adminUserService/admin-user.service';

@Component({
  selector: 'app-list-admin',
  templateUrl: './list-admin.component.html',
  styleUrls: ['./list-admin.component.css']
})
export class ListAdminComponent implements OnInit {

  admins = [];
  btnAjouter = "Ajouter";
  btnNewAdmin = "Nouveau Admin";
  btnModifier = "Modifier";
  btnSupprimer = "Supprimer";
  snapshot: RouterStateSnapshot;
  id = [];
  url: string;
  first = 0;
  rows = 5;
  clonedProducts: { } = {};

  constructor(
    private adminUserService: AdminUserService,
    private router: Router,
    private confirmationService: ConfirmationService
  ) { }

  ngOnInit(): void {
    this.adminUserService.getAdmins().subscribe(
      (data : any) => {
        this.admins = data,
        console.log(data)
      }
    )
  }

  getIdOnUrl() {
    this.snapshot = this.router.routerState.snapshot;
    var url: string;
    url = this.snapshot['url'];
    this.id = url.split('/');
    return this.id[4];
  }

  reloadComponent() {
    let currentUrl = this.router.url;
    this.router.routeReuseStrategy.shouldReuseRoute = () => false;
    this.router.onSameUrlNavigation = 'reload';
    this.router.navigate(['/acceuil/liste/admins']);
  }

  confirmModalNo() {
    return this.reloadComponent();
  }

  currentRoute() {
    var split;
    this.snapshot = this.router.routerState.snapshot;
    this.url = this.snapshot['url'];
    split = this.url.split('/');
    if(split[5] == `modifier`) {
      return true;
    }
    return false;
  }


  onRowEditInit(admin) {
    this.clonedProducts[admin.id] = {...admin};
  }

  onRowEditSave(admin, id) {
    console.log(admin);
    return this.adminUserService.putAdmin(id, admin).subscribe(
      (res: any) => { 
        console.log(res)
      }
    );
  }

  onRowEditCancel(admin, index: number) {
    this.admins[index] = this.clonedProducts[admin.id];
    delete this.clonedProducts[admin.id];
  }

  confirm(event: Event) {
    this.confirmationService.confirm({
        target: event.target,
        message: 'Êtes-vous sure de vouloir supprimer cet Admin?',
        icon: 'pi pi-exclamation-triangle',
        accept: () => {
          var toDelete: number;
          toDelete = this.getIdOnUrl();
          console.log(toDelete);
          //var toRemove = s.slice().pop();
           return this.adminUserService.deleteAdmin(toDelete).subscribe(
            (res: any) => { 
              this.reloadComponent();
              console.log(res)
            }
          );
        },
        reject: () => {
          // return this.reloadComponent();
        }
    });
  }
  
}
