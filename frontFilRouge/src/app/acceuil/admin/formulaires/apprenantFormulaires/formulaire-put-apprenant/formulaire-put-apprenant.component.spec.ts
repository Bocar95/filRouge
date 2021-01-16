import { ComponentFixture, TestBed } from '@angular/core/testing';

import { FormulairePutApprenantComponent } from './formulaire-put-apprenant.component';

describe('FormulairePutApprenantComponent', () => {
  let component: FormulairePutApprenantComponent;
  let fixture: ComponentFixture<FormulairePutApprenantComponent>;

  beforeEach(async () => {
    await TestBed.configureTestingModule({
      declarations: [ FormulairePutApprenantComponent ]
    })
    .compileComponents();
  });

  beforeEach(() => {
    fixture = TestBed.createComponent(FormulairePutApprenantComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
