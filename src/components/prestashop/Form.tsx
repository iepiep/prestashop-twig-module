
import { ReactNode } from "react";
import { Button } from "@/components/ui/button";
import { cn } from "@/lib/utils";

interface FormProps {
  children: ReactNode;
  className?: string;
  onSubmit: (e: React.FormEvent) => void;
  submitText?: string;
  cancelText?: string;
  onCancel?: () => void;
  loading?: boolean;
}

const Form = ({
  children,
  className,
  onSubmit,
  submitText = "Save",
  cancelText = "Cancel",
  onCancel,
  loading = false,
}: FormProps) => {
  return (
    <form
      onSubmit={(e) => {
        e.preventDefault();
        onSubmit(e);
      }}
      className={cn("space-y-6", className)}
    >
      {children}
      
      <div className="flex flex-wrap gap-3 pt-2">
        <Button 
          type="submit" 
          disabled={loading}
          className="animate-hover"
        >
          {loading ? "Saving..." : submitText}
        </Button>
        
        {onCancel && (
          <Button 
            type="button" 
            variant="outline" 
            onClick={onCancel}
            className="animate-hover"
          >
            {cancelText}
          </Button>
        )}
      </div>
    </form>
  );
};

export default Form;
