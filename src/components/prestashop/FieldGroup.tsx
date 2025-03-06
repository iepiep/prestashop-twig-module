
import { ReactNode } from "react";
import { cn } from "@/lib/utils";
import { Label } from "@/components/ui/label";

interface FieldGroupProps {
  children: ReactNode;
  label: string;
  description?: string;
  htmlFor?: string;
  className?: string;
  error?: string;
}

const FieldGroup = ({
  children,
  label,
  description,
  htmlFor,
  className,
  error,
}: FieldGroupProps) => {
  return (
    <div className={cn("space-y-2", className)}>
      <div className="space-y-1">
        {htmlFor ? (
          <Label htmlFor={htmlFor} className="text-sm font-medium">
            {label}
          </Label>
        ) : (
          <div className="text-sm font-medium">{label}</div>
        )}
        
        {description && (
          <p className="text-xs text-muted-foreground">{description}</p>
        )}
      </div>
      
      {children}
      
      {error && (
        <p className="text-xs text-destructive animate-fade-in">{error}</p>
      )}
    </div>
  );
};

export default FieldGroup;
