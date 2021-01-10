import { Component, OnInit } from '@angular/core';
import { ProfilService } from '../../../service/profilService/profil.service';
import { Router, ActivatedRoute } from '@angular/router';
import { HttpClient } from '@angular/common/http';
import { FormBuilder } from '@angular/forms';

@Component({
  selector: 'app-profil',
  templateUrl: './profil.component.html',
  styleUrls: ['./profil.component.css']
})

export class ProfilComponent implements OnInit {

  ok = false;

  constructor(private profilService: ProfilService,
              private router: Router,
              private route: ActivatedRoute,
              private http: HttpClient,
              private formBuilder: FormBuilder
              ) { }

  ngOnInit(): void {
  }

  getIdOnUrl() {
  }

  getById() {
    return this.route.paramMap.subscribe(
      params =>{
        this.profilService.getProfilById(+params.get('id'))
      }
    );
  }

}

