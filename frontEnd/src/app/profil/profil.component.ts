import { Component, Inject, OnInit } from '@angular/core';
import { ProfilService } from '../service/profil.service';
import { Router } from '@angular/router';
import { HttpClient } from '@angular/common/http';

@Component({
  selector: 'app-profil',
  templateUrl: './profil.component.html',
  styleUrls: ['./profil.component.css']
})

export class ProfilComponent implements OnInit {
  
  profils: any = [];
  ok = false;
  btnText = 'Activer';

  constructor(private profilService: ProfilService,
               private router: Router,
               private http: HttpClient
              ) { }

  ngOnInit(): void {
    this.profilService.getProfil().subscribe(
      (data: any) => {
        this.profils = data;
        console.log(data);
      }
    );
  }

  addProfil() {
  }

  onClickBtn() {
    this.ok = !this.ok;
    this.btnText = !this.ok ? 'Activer' : 'Desactiver'
  }

}

