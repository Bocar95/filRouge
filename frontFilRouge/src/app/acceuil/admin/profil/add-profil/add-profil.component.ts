import { Component, Inject, OnInit, Injector } from '@angular/core';
import { FormGroup, FormControl, Validators, FormBuilder } from '@angular/forms';
import { MatDialog, MatDialogRef, MAT_DIALOG_DATA } from '@angular/material/dialog';

import { ProfilService } from 'src/app/service/profil.service';
import { Router } from '@angular/router';


export interface DialogData {
  animal: string;
  name: string;
  libelle: string;
}

@Component({
  selector: 'app-add-profil',
  templateUrl: './add-profil.component.html',
  styleUrls: ['./add-profil.component.css']
})
export class AddProfilComponent implements OnInit {

  addingProfil : FormGroup;
  libelleFormControl = new FormControl('', [Validators.required]);
  btnText = 'Ajouter';
  profils: any = [];
  animal: string;
  name: string;
  	
  constructor(private profilService: ProfilService,
              private formBuilder: FormBuilder,
              private router: Router,
              public dialog: MatDialog
              ) { }

  ngOnInit(): void {
    this.addingProfil = this.formBuilder.group({
      libelle : this.libelleFormControl 
    });
  }

  listProfils() {
    return this.profilService.getProfil().subscribe(
      (data: any) => {
        this.profils = data;
        console.log(data)
      }
    );
  }

  reloadCurrentRoute() {
    let currentUrl = this.router.url;
    return this.router.navigateByUrl('/', {skipLocationChange: true}).then(() => {
        this.router.navigate([currentUrl]);
    });
  }


//this is for reloading component
  // reloadComponent() {
  // let currentUrl = this.router.url;
  //     this.router.routeReuseStrategy.shouldReuseRoute = () => false;
  //     this.router.onSameUrlNavigation = 'reload';
  //     this.router.navigate([currentUrl]);
  // }

  onClickBtnAdd() {
    if(this.addingProfil.value){
      return this.profilService.addProfil(this.addingProfil.value).subscribe(
        (res: any) => {
          this.reloadCurrentRoute()
          console.log(res)
        }
      );
    }
  }

}


@Component({
  selector: 'dialog-overview-example-dialog',
  templateUrl: './popups/dialog-overview-example-dialog.html'
})
export class DialogOverviewExampleDialog {

  addingProfil : FormGroup;
  libelleFormControl = new FormControl('', [Validators.required]);

  constructor(
    public dialogRef: MatDialogRef<DialogOverviewExampleDialog>,
    @Inject(MAT_DIALOG_DATA) public data: DialogData
    ) {}

  onNoClick(): void {
    this.dialogRef.close();
  }

}

  // openDialog(): void {
  //   const dialogRef = this.dialog.open(DialogOverviewExampleDialog, {
  //     width: '250px',
  //     data: {name: this.name, animal: this.animal}
  //   });

  //   dialogRef.afterClosed().subscribe(result => {
  //     console.log('The dialog was closed');
  //     this.animal = result;
  //   });
  // }
