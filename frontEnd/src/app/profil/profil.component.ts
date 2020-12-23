import { Component, Inject, OnInit } from '@angular/core';
import { ProfilService } from '../service/profil.service';
import { Router } from '@angular/router';
import { HttpClient } from '@angular/common/http';
import { FormGroup, FormControl, Validators, FormBuilder } from '@angular/forms';

@Component({
  selector: 'app-profil',
  templateUrl: './profil.component.html',
  styleUrls: ['./profil.component.css']
})

export class ProfilComponent implements OnInit {
  
  profils: any = [];
  addingProfil : FormGroup;
  libelleFormControl = new FormControl('', [Validators.required]);
  ok = false;
  btnText = 'Ajouter';

  constructor(private profilService: ProfilService,
               private router: Router,
               private http: HttpClient,
               private formBuilder: FormBuilder
              ) { }

  ngOnInit(): void {
    this.profilService.getProfil().subscribe(
      (data: any) => {
        this.profils = data;
        console.log(data);
      }
    );
    this.addingProfil = this.formBuilder.group({
      libelle : this.libelleFormControl 
    });
  }
  
  onClickBtn() {
    if(this.addingProfil.value){
      this.profilService.addProfil(this.addingProfil.value).subscribe(
        (res: any) => {
          console.log(res)
        }
      );
    }
  }

}

