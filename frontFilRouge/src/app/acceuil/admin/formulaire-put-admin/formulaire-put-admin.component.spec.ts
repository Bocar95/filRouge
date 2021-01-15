import { ComponentFixture, TestBed } from '@angular/core/testing';

import { FormulairePutAdminComponent } from './formulaire-put-admin.component';

describe('FormulairePutAdminComponent', () => {
  let component: FormulairePutAdminComponent;
  let fixture: ComponentFixture<FormulairePutAdminComponent>;

  beforeEach(async () => {
    await TestBed.configureTestingModule({
      declarations: [ FormulairePutAdminComponent ]
    })
    .compileComponents();
  });

  beforeEach(() => {
    fixture = TestBed.createComponent(FormulairePutAdminComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
