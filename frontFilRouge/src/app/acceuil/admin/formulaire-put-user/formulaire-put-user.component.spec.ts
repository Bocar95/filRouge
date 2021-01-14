import { ComponentFixture, TestBed } from '@angular/core/testing';

import { FormulairePutUserComponent } from './formulaire-put-user.component';

describe('FormulairePutUserComponent', () => {
  let component: FormulairePutUserComponent;
  let fixture: ComponentFixture<FormulairePutUserComponent>;

  beforeEach(async () => {
    await TestBed.configureTestingModule({
      declarations: [ FormulairePutUserComponent ]
    })
    .compileComponents();
  });

  beforeEach(() => {
    fixture = TestBed.createComponent(FormulairePutUserComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
