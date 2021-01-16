import { ComponentFixture, TestBed } from '@angular/core/testing';

import { FormulairePutCmComponent } from './formulaire-put-cm.component';

describe('FormulairePutCmComponent', () => {
  let component: FormulairePutCmComponent;
  let fixture: ComponentFixture<FormulairePutCmComponent>;

  beforeEach(async () => {
    await TestBed.configureTestingModule({
      declarations: [ FormulairePutCmComponent ]
    })
    .compileComponents();
  });

  beforeEach(() => {
    fixture = TestBed.createComponent(FormulairePutCmComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
